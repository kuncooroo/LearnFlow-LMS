<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Users\ImportUsersFromCsvAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ImportUsersRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        return view('admin.users.index');
    }

    public function create(): View
    {
        $this->authorize('create', User::class);

        return view('admin.users.create');
    }

    public function show(User $user): View
    {
        $this->authorize('view', $user);

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        return view('admin.users.edit', compact('user'));
    }

    public function import(): View
    {
        $this->authorize('import', User::class);

        return view('admin.users.import');
    }

    public function storeImport(
        ImportUsersRequest $request,
        ImportUsersFromCsvAction $importUsersFromCsv,
    ): RedirectResponse {
        $contents = $request->file('file')?->get();

        if (! is_string($contents)) {
            return back()->withErrors(['file' => __('Unable to read the uploaded file.')]);
        }

        $parsed = $importUsersFromCsv->parseRows($contents);
        $result = $importUsersFromCsv->execute($parsed['rows'], $request->user());

        $mergedFailed = array_merge($parsed['failed'], $result->failed);

        return redirect()
            ->route('admin.users.import')
            ->with('import_result', [
                'created' => $result->createdCount(),
                'skipped' => $result->skippedCount(),
                'failed' => count($mergedFailed),
                'details' => [
                    'created' => $result->created,
                    'skipped' => $result->skipped,
                    'failed' => $mergedFailed,
                ],
            ]);
    }

    public function downloadTemplate(): StreamedResponse
    {
        $this->authorize('import', User::class);

        $headers = ImportUsersFromCsvAction::EXPECTED_HEADERS;

        return response()->streamDownload(function () use ($headers): void {
            echo implode(',', $headers)."\n";
            echo 'Jane Instructor,jane@example.com,ChangeMe123!,active,instructor'."\n";
        }, 'users-import-template.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }
}
