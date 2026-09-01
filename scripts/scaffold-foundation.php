<?php

declare(strict_types=1);

$root = dirname(__DIR__);

$directories = [
    'app/Actions/Auth',
    'app/Actions/Users',
    'app/Actions/Access',
    'app/Actions/Institution',
    'app/Actions/Files',
    'app/Actions/Courses',
    'app/Actions/Enrollments',
    'app/Actions/Content',
    'app/Actions/Assignments',
    'app/Actions/Quizzes',
    'app/Actions/Grades',
    'app/Actions/Progress',
    'app/Actions/Announcements',
    'app/Actions/Discussions',
    'app/Actions/Reports',
    'app/Data',
    'app/Enums',
    'app/Services/Audit',
    'app/Services/Files',
    'app/Services/Progress',
    'app/Services/Reports',
    'app/Livewire/Admin',
    'app/Livewire/Instructor',
    'app/Livewire/Student',
    'app/Livewire/Shared',
    'app/Support/Traits',
    'app/Support/Helpers',
    'resources/views/layouts/partials',
    'resources/views/components',
    'resources/views/errors',
    'resources/views/livewire/shared',
    'tests/Livewire/Shared',
];

foreach ($directories as $directory) {
    $path = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $directory);

    if (! is_dir($path)) {
        mkdir($path, 0777, true);
    }

    $gitkeep = $path . DIRECTORY_SEPARATOR . '.gitkeep';
    if (! file_exists($gitkeep)) {
        file_put_contents($gitkeep, '');
    }
}

$docMap = [
    'PRD(4).md' => 'docs/PRD.md',
    'SRS(3).md' => 'docs/SRS.md',
    'SYSTEM_DESIGN(4).md' => 'docs/SYSTEM_DESIGN.md',
    'BUSINESS_FLOW(4).md' => 'docs/BUSINESS_FLOW.md',
    'DATABASE(3).md' => 'docs/DATABASE.md',
    'ROADMAP(3).md' => 'docs/ROADMAP.md',
    'UI_UX(3).md' => 'docs/UI_UX.md',
    'CURSOR(2).md' => 'CURSOR.md',
];

foreach ($docMap as $source => $target) {
    $from = $root . DIRECTORY_SEPARATOR . $source;
    $to = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $target);

    if (file_exists($from)) {
        copy($from, $to);
    }
}

if (file_exists($root . DIRECTORY_SEPARATOR . 'CURSOR.md')) {
    copy($root . DIRECTORY_SEPARATOR . 'CURSOR.md', $root . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . 'CURSOR.md');
}

echo "Foundation directories and docs normalized.\n";
