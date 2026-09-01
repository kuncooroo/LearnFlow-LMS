<?php

namespace Tests\Feature\Admin\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\Concerns\RequiresDatabase;
use Tests\Concerns\SeedsRolesAndPermissions;
use Tests\TestCase;

class UserAuthorizationTest extends TestCase
{
    use RefreshDatabase;
    use RequiresDatabase;
    use SeedsRolesAndPermissions;

    protected function setUp(): void
    {
        $this->skipIfDatabaseUnavailable();

        parent::setUp();

        $this->seedRolesAndPermissions();
    }

    public function test_student_cannot_access_admin_user_routes(): void
    {
        $student = User::factory()->student()->create();

        $this->actingAs($student)
            ->get(route('admin.users.index'))
            ->assertForbidden();
    }

    public function test_instructor_cannot_access_admin_user_routes(): void
    {
        $instructor = User::factory()->instructor()->create();

        $this->actingAs($instructor)
            ->get(route('admin.users.create'))
            ->assertForbidden();
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('admin.users.index'))
            ->assertRedirect(route('login'));
    }
}
