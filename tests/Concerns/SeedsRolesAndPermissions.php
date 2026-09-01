<?php

namespace Tests\Concerns;

use Database\Seeders\RolesAndPermissionsSeeder;

trait SeedsRolesAndPermissions
{
    protected function seedRolesAndPermissions(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);
    }
}
