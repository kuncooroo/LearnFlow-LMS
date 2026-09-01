<?php

namespace Tests\Feature\Admin\Users;

use App\Actions\Users\ImportUsersFromCsvAction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\Concerns\RequiresDatabase;
use Tests\Concerns\SeedsRolesAndPermissions;
use Tests\TestCase;

class UserImportTest extends TestCase
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

    public function test_admin_can_import_valid_csv_rows(): void
    {
        $admin = User::factory()->administrator()->create();

        $csv = implode("\n", [
            'name,email,password,status,role',
            'Imported Student,imported@example.com,password123,active,student',
        ]);

        $file = UploadedFile::fake()->createWithContent('users.csv', $csv);

        $this->actingAs($admin)
            ->post(route('admin.users.import.store'), ['file' => $file])
            ->assertRedirect(route('admin.users.import'))
            ->assertSessionHas('import_result');

        $this->assertDatabaseHas('users', ['email' => 'imported@example.com']);
    }

    public function test_invalid_csv_headers_are_rejected(): void
    {
        $admin = User::factory()->administrator()->create();

        $csv = "wrong,headers\nFoo,bar\n";
        $file = UploadedFile::fake()->createWithContent('users.csv', $csv);

        $this->actingAs($admin)
            ->post(route('admin.users.import.store'), ['file' => $file])
            ->assertSessionHasErrors('file');
    }

    public function test_import_reports_duplicate_email_as_skipped(): void
    {
        $admin = User::factory()->administrator()->create();
        User::factory()->student()->create(['email' => 'existing@example.com']);

        $action = app(ImportUsersFromCsvAction::class);
        $parsed = $action->parseRows(implode("\n", [
            'name,email,password,status,role',
            'Existing User,existing@example.com,password123,active,student',
            'New User,new@example.com,password123,active,student',
        ]));

        $result = $action->execute($parsed['rows'], $admin);

        $this->assertSame(1, $result->createdCount());
        $this->assertSame(1, $result->skippedCount());
        $this->assertDatabaseHas('users', ['email' => 'new@example.com']);
    }
}
