<?php

namespace Tests\Unit;

use App\Models\AccessCode;
use App\Models\Assignment;
use App\Models\Location;
use App\Models\Locker;
use App\Models\Maintenance;
use App\Models\UsageHistory;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class ModelRelationshipTest extends TestCase
{
    public function test_relationship_methods_exist(): void
    {
        $this->assertTrue(method_exists(new User, 'assignments'));
        $this->assertTrue(method_exists(new User, 'usageHistories'));
        $this->assertTrue(method_exists(new User, 'maintenances'));
        $this->assertTrue(method_exists(new Location, 'lockers'));
        $this->assertTrue(method_exists(new Locker, 'location'));
        $this->assertTrue(method_exists(new Assignment, 'accessCodes'));
        $this->assertTrue(method_exists(new Assignment, 'usageHistory'));
        $this->assertTrue(method_exists(new AccessCode, 'assignment'));
        $this->assertTrue(method_exists(new UsageHistory, 'assignment'));
        $this->assertTrue(method_exists(new Maintenance, 'reporter'));
    }
}
