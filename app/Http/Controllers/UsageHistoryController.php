<?php

namespace App\Http\Controllers;

use App\Models\UsageHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsageHistoryController extends Controller
{
    // /user/usage-history: only my own usage
    public function index(Request $request): View
    {
        return view('user.usage-history.index', $this->report($request, $request->user()->id));
    }

    // /staff/usage-history: everyone's usage
    public function staff(Request $request): View
    {
        return view('staff.usage-history.index', $this->report($request, null));
    }

    private function report(Request $request, ?int $userId): array
    {
        $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
        ]);

        // ---- date range (default: last 7 days, max 31 days) ----
        $to = $request->filled('to') ? Carbon::parse($request->input('to'))->endOfDay() : now()->endOfDay();
        $from = $request->filled('from') ? Carbon::parse($request->input('from'))->startOfDay() : $to->copy()->subDays(6)->startOfDay();

        if ($from->gt($to)) {
            [$from, $to] = [$to->copy()->startOfDay(), $from->copy()->endOfDay()];
        }

        $days = (int) $from->copy()->startOfDay()->diffInDays($to->copy()->startOfDay()) + 1;
        if ($days > 31) {
            $from = $to->copy()->subDays(30)->startOfDay();
            $days = 31;
        }

        // previous period of the same length, for the "vs previous" comparison
        $prevTo = $from->copy()->subDay()->endOfDay();
        $prevFrom = $prevTo->copy()->subDays($days - 1)->startOfDay();

        $base = fn () => UsageHistory::query()
            ->when($userId, fn ($q) => $q->where('locker_usages.user_id', $userId));

        // ---- numbers for one period ----
        $metrics = function (Carbon $a, Carbon $b) use ($base) {
            $row = $base()
                ->whereBetween('end_time', [$a, $b])
                ->selectRaw('avg(extract(epoch from (end_time - start_time))) as secs')
                ->first();

            return [
                'checkins' => $base()->whereBetween('start_time', [$a, $b])->count(),
                'releases' => $base()->whereBetween('end_time', [$a, $b])->count(),
                'users' => $base()->whereBetween('start_time', [$a, $b])->distinct()->count('user_id'),
                'avg' => (float) ($row?->secs ?? 0),
            ];
        };

        $cur = $metrics($from, $to);
        $prev = $metrics($prevFrom, $prevTo);

        $pct = fn ($now, $before) => $before > 0 ? (int) round(($now - $before) / $before * 100) : null;

        $fmt = function (float $secs) {
            if ($secs <= 0) {
                return '—';
            }
            $m = (int) round($secs / 60);

            return $m < 60 ? $m.'m' : intdiv($m, 60).'h '.($m % 60).'m';
        };

        // Card 3: active users for staff, lockers in use right now for a normal user
        $card3 = $userId
            ? ['label' => 'Lockers In Use', 'value' => number_format($base()->whereNull('end_time')->count()), 'change' => null, 'note' => 'Right now']
            : ['label' => 'Active Users', 'value' => number_format($cur['users']), 'change' => $pct($cur['users'], $prev['users'])];

        $cards = [
            ['key' => 'checkins', 'label' => 'Total Check-ins', 'value' => number_format($cur['checkins']), 'change' => $pct($cur['checkins'], $prev['checkins'])],
            ['key' => 'releases', 'label' => 'Total Releases', 'value' => number_format($cur['releases']), 'change' => $pct($cur['releases'], $prev['releases'])],
            ['key' => 'users', ...$card3],
            ['key' => 'duration', 'label' => 'Avg. Duration', 'value' => $fmt($cur['avg']), 'change' => $pct($cur['avg'], $prev['avg'])],
        ];

        // ---- daily trend ----
        $checkinsByDay = $base()->whereBetween('start_time', [$from, $to])
            ->selectRaw('date(start_time) as d, count(*) as c')->groupBy('d')->pluck('c', 'd');
        $releasesByDay = $base()->whereBetween('end_time', [$from, $to])
            ->selectRaw('date(end_time) as d, count(*) as c')->groupBy('d')->pluck('c', 'd');

        $labels = $in = $out = [];
        for ($i = 0; $i < $days; $i++) {
            $day = $from->copy()->addDays($i);
            $key = $day->toDateString();
            $labels[] = $day->format('j M');
            $in[] = (int) ($checkinsByDay[$key] ?? 0);
            $out[] = (int) ($releasesByDay[$key] ?? 0);
        }

        $yMax = max(10, (int) (ceil(max(max($in), max($out)) / 10) * 10));

        // SVG coordinates for the chart (viewBox 600 x 190, baseline at y = 170)
        $toPoints = fn (array $vals) => collect($vals)->map(fn ($v, $i) => [
            round($days > 1 ? $i * 600 / ($days - 1) : 300, 1),
            round(170 - $v / $yMax * 160, 1),
        ])->all();

        $idx = $days <= 8
            ? range(0, $days - 1)
            : array_values(array_unique(array_map(fn ($k) => (int) round($k * ($days - 1) / 6), range(0, 6))));

        $chart = [
            'yMax' => $yMax,
            'in' => $toPoints($in),
            'out' => $toPoints($out),
            'xLabels' => array_map(fn ($i) => $labels[$i], $idx),
            'empty' => array_sum($in) + array_sum($out) === 0,
        ];

        // ---- top locations ----
        $top = UsageHistory::query()
            ->when($userId, fn ($q) => $q->where('locker_usages.user_id', $userId))
            ->whereBetween('locker_usages.start_time', [$from, $to])
            ->join('lockers', 'lockers.id', '=', 'locker_usages.locker_id')
            ->join('locations', 'locations.id', '=', 'lockers.location_id')
            ->selectRaw('locations.name as name, count(*) as total')
            ->groupBy('locations.id', 'locations.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return [
            'from' => $from,
            'to' => $to,
            'mine' => (bool) $userId,
            'cards' => $cards,
            'chart' => $chart,
            'top' => $top,
        ];
    }
}
