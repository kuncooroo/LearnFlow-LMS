<?php

namespace Database\Seeders;

use App\Enums\PermissionName;
use App\Enums\RoleName;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            PermissionName::UsersManage->value => 'Manage users',
            PermissionName::RolesManage->value => 'Manage roles and permissions',
            PermissionName::SettingsManage->value => 'Manage institution settings',
            PermissionName::CoursesManage->value => 'Manage courses',
            PermissionName::CoursesTeach->value => 'Teach assigned courses',
            PermissionName::EnrollmentsManage->value => 'Manage enrollments',
            PermissionName::ReportsView->value => 'View reports',
            PermissionName::AuditView->value => 'View audit logs',
        ];

        foreach ($permissions as $name => $displayName) {
            Permission::query()->updateOrCreate(
                ['name' => $name],
                ['display_name' => $displayName],
            );
        }
    }
}
