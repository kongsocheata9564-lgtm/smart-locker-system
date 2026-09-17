<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\Location;
use App\Models\Locker;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmartLockerFoundationTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_migrations_create_smart_locker_tables(): void
    {
        $this->artisan('migrate');

        $this->assertDatabaseEmpty('locations');
        $this->assertDatabaseEmpty('lockers');
        $this->assertDatabaseEmpty('assignments');
        $this->assertDatabaseEmpty('access_codes');
        $this->assertDatabaseEmpty('usage_histories');
        $this->assertDatabaseEmpty('maintenances');
    }

    public function test_user_roles_can_be_stored(): void
    {
        $admin = User::factory()->admin()->create();
        $staff = User::factory()->staff()->create();
        $user = User::factory()->create();

        $this->assertSame('admin', $admin->role);
        $this->assertSame('staff', $staff->role);
        $this->assertSame('user', $user->role);
    }

    public function test_location_can_be_created(): void
    {
        $location = Location::create([
            'name' => 'Central Library',
            'type' => 'library',
            'address' => 'Library Road',
            'description' => 'Library entrance locker area.',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('locations', [
            'id' => $location->id,
            'name' => 'Central Library',
            'type' => 'library',
            'status' => 'active',
        ]);
    }

    public function test_locker_belongs_to_location(): void
    {
        $location = Location::factory()->create();
        $locker = Locker::factory()->create(['location_id' => $location->id]);

        $this->assertTrue($locker->location->is($location));
        $this->assertTrue($location->lockers->contains($locker));
    }

    public function test_assignment_belongs_to_user_and_locker(): void
    {
        $user = User::factory()->create();
        $locker = Locker::factory()->create();
        $assignment = Assignment::factory()->create([
            'user_id' => $user->id,
            'locker_id' => $locker->id,
        ]);

        $this->assertTrue($assignment->user->is($user));
        $this->assertTrue($assignment->locker->is($locker));
    }
}
