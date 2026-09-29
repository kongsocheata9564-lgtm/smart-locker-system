<?php

namespace App\Http\Controllers;

use App\Models\UsageHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsageHistoryController extends Controller
{
    // /user/usage-history
    // Only show the logged-in user's usage
    public function index(Request $request): View
    {
        return view(
            'user.usage-history.index',
            $this->report($request, $request->user()->id)
        );
    }

    // /staff/usage-history
    // Show everyone's usage
    public function staff(Request $request): View
    {
        return view(
            'staff.usage-history.index',
            $this->report($request, null)
        );
    }

    private function report(Request $request, ?int $userId): array
    {
        // ---------------------------------------------------------
        // Validate date
        // ---------------------------------------------------------

        $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
        ]);

        // ---------------------------------------------------------
        // Date range
        // Default: last 7 days
        // Maximum: 31 days
        // ---------------------------------------------------------

        $to = $request->filled('to')
            ? Carbon::parse($request->input('to'))->endOfDay()
            : now()->endOfDay();

        $from = $request->filled('from')
            ? Carbon::parse($request->input('from'))->startOfDay()
            : $to->copy()->subDays(6)->startOfDay();

        // If from > to, swap them
        if ($from->gt($to)) {
            [$from, $to] = [
                $to->copy()->startOfDay(),
                $from->copy()->endOfDay(),
            ];
        }

        // Number of days
        $days = (int) $from
            ->copy()
            ->startOfDay()
            ->diffInDays($to->copy()->startOfDay()) + 1;

        // Maximum 31 days
        if ($days > 31) {
            $from = $to->copy()
                ->subDays(30)
                ->startOfDay();

            $days = 31;
        }

        // ---------------------------------------------------------
        // Previous period
        // ---------------------------------------------------------

        $prevTo = $from
            ->copy()
            ->subDay()
            ->endOfDay();

        $prevFrom = $prevTo
            ->copy()
            ->subDays($days - 1)
            ->startOfDay();

        // ---------------------------------------------------------
        // Base query
        //
        // User:
        //      only their own records
        //
        // Staff:
        //      all records
        // ---------------------------------------------------------

        $base = fn () => UsageHistory::query()
            ->when(
                $userId,
                fn ($q) => $q->where(
                    'locker_usages.user_id',
                    $userId
                )
            );

        // ---------------------------------------------------------
        // Metrics
        // ---------------------------------------------------------

        $metrics = function (Carbon $a, Carbon $b) use ($base) {

            // Average duration
            $row = $base()
                ->whereBetween(
                    'end_time',
                    [$a, $b]
                )
                ->selectRaw(
                    'avg(extract(epoch from (end_time - start_time))) as secs'
                )
                ->first();

            return [

                // Check-ins
                'checkins' => $base()
                    ->whereBetween(
                        'start_time',
                        [$a, $b]
                    )
                    ->count(),

                // Releases
                'releases' => $base()
                    ->whereBetween(
                        'end_time',
                        [$a, $b]
                    )
                    ->count(),

                // Unique users
                'users' => $base()
                    ->whereBetween(
                        'start_time',
                        [$a, $b]
                    )
                    ->distinct()
                    ->count('user_id'),

                // Average duration in seconds
                'avg' => (float) ($row?->secs ?? 0),
            ];
        };

        $cur = $metrics($from, $to);
        $prev = $metrics($prevFrom, $prevTo);

        // ---------------------------------------------------------
        // Percentage change
        // ---------------------------------------------------------

        $pct = fn ($now, $before) => $before > 0
                ? (int) round(
                    (($now - $before) / $before) * 100
                )
                : null;

        // ---------------------------------------------------------
        // Format duration
        // ---------------------------------------------------------

        $fmt = function (float $secs) {

            if ($secs <= 0) {
                return '—';
            }

            $minutes = (int) round($secs / 60);

            return $minutes < 60
                ? $minutes.'m'
                : intdiv($minutes, 60)
                    .'h '
                    .($minutes % 60)
                    .'m';
        };

        // ---------------------------------------------------------
        // Card 3
        // ---------------------------------------------------------

        if ($userId) {

            // Normal user
            $card3 = [
                'label' => 'Lockers In Use',

                'value' => number_format(
                    $base()
                        ->whereNull('end_time')
                        ->count()
                ),

                'change' => null,

                'note' => 'Right now',
            ];

        } else {

            // Staff
            $card3 = [
                'label' => 'Active Users',

                'value' => number_format(
                    $cur['users']
                ),

                'change' => $pct(
                    $cur['users'],
                    $prev['users']
                ),
            ];
        }

        // ---------------------------------------------------------
        // Statistic cards
        // ---------------------------------------------------------

        $cards = [

            [
                'key' => 'checkins',
                'label' => 'Total Check-ins',
                'value' => number_format(
                    $cur['checkins']
                ),
                'change' => $pct(
                    $cur['checkins'],
                    $prev['checkins']
                ),
            ],

            [
                'key' => 'releases',
                'label' => 'Total Releases',
                'value' => number_format(
                    $cur['releases']
                ),
                'change' => $pct(
                    $cur['releases'],
                    $prev['releases']
                ),
            ],

            [
                'key' => 'users',
                ...$card3,
            ],

            [
                'key' => 'duration',
                'label' => 'Avg. Duration',
                'value' => $fmt(
                    $cur['avg']
                ),
                'change' => $pct(
                    $cur['avg'],
                    $prev['avg']
                ),
            ],
        ];

        // ---------------------------------------------------------
        // Daily trend
        // ---------------------------------------------------------

        $checkinsByDay = $base()
            ->whereBetween(
                'start_time',
                [$from, $to]
            )
            ->selectRaw(
                'date(start_time) as d, count(*) as c'
            )
            ->groupBy('d')
            ->pluck('c', 'd');

        $releasesByDay = $base()
            ->whereBetween(
                'end_time',
                [$from, $to]
            )
            ->selectRaw(
                'date(end_time) as d, count(*) as c'
            )
            ->groupBy('d')
            ->pluck('c', 'd');

        $labels = [];
        $in = [];
        $out = [];

        for ($i = 0; $i < $days; $i++) {

            $day = $from->copy()->addDays($i);

            $key = $day->toDateString();

            $labels[] = $day->format('j M');

            $in[] = (int) (
                $checkinsByDay[$key] ?? 0
            );

            $out[] = (int) (
                $releasesByDay[$key] ?? 0
            );
        }

        // ---------------------------------------------------------
        // Chart maximum
        // ---------------------------------------------------------

        $yMax = max(
            10,
            (int) (
                ceil(
                    max(
                        max($in),
                        max($out)
                    ) / 10
                ) * 10
            )
        );

        // ---------------------------------------------------------
        // SVG chart points
        // ---------------------------------------------------------

        $toPoints = fn (array $vals) => collect($vals)
            ->map(
                fn ($v, $i) => [

                    round(
                        $days > 1
                            ? $i * 600 / ($days - 1)
                            : 300,
                        1
                    ),

                    round(
                        170 - ($v / $yMax * 160),
                        1
                    ),
                ]
            )
            ->all();

        // ---------------------------------------------------------
        // X-axis labels
        // ---------------------------------------------------------

        $idx = $days <= 8

            ? range(0, $days - 1)

            : array_values(
                array_unique(
                    array_map(
                        fn ($k) => (int) round(
                            $k * ($days - 1) / 6
                        ),
                        range(0, 6)
                    )
                )
            );

        // ---------------------------------------------------------
        // Chart data
        // ---------------------------------------------------------

        $chart = [

            'yMax' => $yMax,

            'in' => $toPoints($in),

            'out' => $toPoints($out),

            'xLabels' => array_map(
                fn ($i) => $labels[$i],
                $idx
            ),

            'empty' => array_sum($in) +
                array_sum($out) === 0,
        ];

        // ---------------------------------------------------------
        // Top locations
        // ---------------------------------------------------------

        $top = UsageHistory::query()

            ->when(
                $userId,
                fn ($q) => $q->where(
                    'locker_usages.user_id',
                    $userId
                )
            )

            ->whereBetween(
                'locker_usages.start_time',
                [$from, $to]
            )

            ->join(
                'lockers',
                'lockers.id',
                '=',
                'locker_usages.locker_id'
            )

            ->join(
                'locations',
                'locations.id',
                '=',
                'lockers.location_id'
            )

            ->selectRaw(
                'locations.name as name, count(*) as total'
            )

            ->groupBy(
                'locations.id',
                'locations.name'
            )

            ->orderByDesc('total')

            ->limit(5)

            ->get();

        // ---------------------------------------------------------
        // Usage history table
        // ---------------------------------------------------------

        $usages = UsageHistory::query()

            ->when(
                $userId,
                fn ($q) => $q->where(
                    'locker_usages.user_id',
                    $userId
                )
            )

            ->whereBetween(
                'locker_usages.start_time',
                [$from, $to]
            )

            ->join(
                'lockers',
                'lockers.id',
                '=',
                'locker_usages.locker_id'
            )

            ->join(
                'locations',
                'locations.id',
                '=',
                'lockers.location_id'
            )

            ->select([
                'locker_usages.id',
                'locker_usages.start_time',
                'locker_usages.end_time',
                'locker_usages.status',

                'lockers.name as locker_name',

                'locations.name as location_name',
            ])

            ->orderByDesc(
                'locker_usages.start_time'
            )

            ->get();

        // ---------------------------------------------------------
        // Send everything to Blade
        // ---------------------------------------------------------

        return [

            'from' => $from,

            'to' => $to,

            'mine' => (bool) $userId,

            'cards' => $cards,

            'chart' => $chart,

            'top' => $top,

            'usages' => $usages,
        ];
    }
}
