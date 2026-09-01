<?php

namespace App\Actions\Users;

use App\Data\Users\ImportUserRow;
use App\Data\Users\ImportUsersResult;
use App\Enums\PermissionName;
use App\Enums\RoleName;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ImportUsersFromCsvAction
{
    public const EXPECTED_HEADERS = ['name', 'email', 'password', 'status', 'role'];

    public function __construct(
        private readonly CreateUserAction $createUserAction,
    ) {}

    /**
     * @param  list<ImportUserRow>  $rows
     */
    public function execute(array $rows, User $actor): ImportUsersResult
    {
        if (! $actor->hasPermission(PermissionName::UsersManage)) {
            throw ValidationException::withMessages([
                'authorization' => __('You are not authorized to import users.'),
            ]);
        }

        $created = [];
        $skipped = [];
        $failed = [];

        $seenEmails = User::query()->pluck('email')->map(fn (string $email) => strtolower($email))->all();
        $seenEmails = array_flip($seenEmails);

        foreach ($rows as $row) {
            $emailKey = strtolower($row->email);

            if (isset($seenEmails[$emailKey])) {
                $skipped[] = [
                    'line' => $row->lineNumber,
                    'email' => $row->email,
                    'reason' => __('Email already exists.'),
                ];

                continue;
            }

            try {
                DB::transaction(function () use ($row, $actor, &$created, &$seenEmails, $emailKey): void {
                    $role = \App\Models\Role::query()
                        ->where('name', $row->role->value)
                        ->firstOrFail();

                    $user = $this->createUserAction->execute([
                        'name' => $row->name,
                        'email' => $row->email,
                        'password' => $row->password ?? throw ValidationException::withMessages([
                            'password' => __('Password is required.'),
                        ]),
                        'status' => $row->status,
                        'role_id' => $role->id,
                    ], $actor);

                    $created[] = [
                        'line' => $row->lineNumber,
                        'email' => $user->email,
                    ];

                    $seenEmails[$emailKey] = true;
                });
            } catch (ValidationException $exception) {
                $failed[] = [
                    'line' => $row->lineNumber,
                    'email' => $row->email,
                    'reason' => collect($exception->errors())->flatten()->first()
                        ?? __('Validation failed.'),
                ];
            } catch (\Throwable $exception) {
                $failed[] = [
                    'line' => $row->lineNumber,
                    'email' => $row->email,
                    'reason' => __('Import failed for this row.'),
                ];
            }
        }

        return new ImportUsersResult($created, $skipped, $failed);
    }

    /**
     * @return array{rows: list<ImportUserRow>, failed: list<array{line: int, email: string, reason: string}>}
     */
    public function parseRows(string $contents): array
    {
        $lines = preg_split('/\R/', trim($contents)) ?: [];
        $failed = [];

        if ($lines === []) {
            throw ValidationException::withMessages([
                'file' => __('The CSV file is empty.'),
            ]);
        }

        $header = str_getcsv(array_shift($lines) ?: '');
        $normalizedHeader = array_map(fn (string $column) => strtolower(trim($column)), $header);

        if ($normalizedHeader !== self::EXPECTED_HEADERS) {
            throw ValidationException::withMessages([
                'file' => __('Invalid CSV headers. Expected: :headers', [
                    'headers' => implode(', ', self::EXPECTED_HEADERS),
                ]),
            ]);
        }

        $rows = [];

        foreach ($lines as $index => $line) {
            if (trim($line) === '') {
                continue;
            }

            $lineNumber = $index + 2;
            $columns = str_getcsv($line);

            if (count($columns) !== count(self::EXPECTED_HEADERS)) {
                $failed[] = [
                    'line' => $lineNumber,
                    'email' => $columns[1] ?? '',
                    'reason' => __('Invalid number of columns.'),
                ];

                continue;
            }

            [$name, $email, $password, $statusValue, $roleValue] = $columns;
            $email = strtolower(trim($email));

            if (trim($name) === '' || $email === '') {
                $failed[] = [
                    'line' => $lineNumber,
                    'email' => $email,
                    'reason' => __('Name and email are required.'),
                ];

                continue;
            }

            try {
                $status = $statusValue !== ''
                    ? UserStatus::from(strtolower(trim($statusValue)))
                    : UserStatus::Active;
                $role = RoleName::from(strtolower(trim($roleValue)));
            } catch (\ValueError) {
                $failed[] = [
                    'line' => $lineNumber,
                    'email' => $email,
                    'reason' => __('Invalid status or role value.'),
                ];

                continue;
            }

            $rows[] = new ImportUserRow(
                lineNumber: $lineNumber,
                name: trim($name),
                email: $email,
                password: trim($password) !== '' ? trim($password) : null,
                status: $status,
                role: $role,
            );
        }

        return [
            'rows' => $rows,
            'failed' => $failed,
        ];
    }
}
