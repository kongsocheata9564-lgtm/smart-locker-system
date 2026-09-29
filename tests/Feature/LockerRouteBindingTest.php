<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Locker;
use App\Models\UsageHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LockerRouteBindingTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_resolves_a_locker_by_its_name(): void
    {
        $location = Location::query()->create([
            'name' => 'ABC Mall',
            'category' => 'Shopping Mall',
            'address' => '123 Monivong Boulevard',
        ]);
        $locker = Locker::query()->create([
            'name' => 'L-001',
            'location_id' => $location->id,
            'status' => 'available',
            'type' => 'small',
        ]);
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('locker.show', $locker))
            ->assertSee('L-001');
    }

    public function test_location_page_lists_lockers_from_the_database(): void
    {
        $location = Location::query()->create([
            'name' => 'Central Library',
            'category' => 'Library',
            'address' => '1 Library Road',
        ]);
        $locker = Locker::query()->create([
            'name' => 'LIB-042',
            'location_id' => $location->id,
            'status' => 'available',
            'type' => 'large',
        ]);

        $this->get(route('location.show', $location))
            ->assertOk()
            ->assertSee($locker->name)
            ->assertSee(route('locker.show', $locker));
    }

    public function test_user_can_assign_and_release_a_locker_with_the_generated_code(): void
    {
        $location = Location::query()->create([
            'name' => 'ABC Mall',
            'category' => 'Shopping Mall',
            'address' => '123 Monivong Boulevard',
        ]);
        $locker = Locker::query()->create([
            'name' => 'L-001',
            'location_id' => $location->id,
            'status' => 'available',
            'type' => 'small',
        ]);
        $user = User::factory()->create();

        $assignResponse = $this->actingAs($user)
            ->post(route('locker.assign', $locker));

        $usage = UsageHistory::query()->firstOrFail();
        $code = session('locker_code_'.$usage->id);

        $assignResponse->assertRedirect(route('locker.code', $locker));
        $this->assertIsString($code);
        $this->assertTrue(Hash::check($code, $usage->one_time_password));
        $this->assertDatabaseHas('lockers', [
            'id' => $locker->id,
            'status' => 'occupied',
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->post(route('locker.release.store', $locker), ['code' => $code])
            ->assertRedirect(route('locker.released', $locker));

        $this->assertDatabaseHas('lockers', [
            'id' => $locker->id,
            'status' => 'available',
            'user_id' => null,
        ]);
        $this->assertNotNull($usage->fresh()->end_time);
    }
}
