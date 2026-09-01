<?php

declare(strict_types=1);

/**
 * One-time import of the Laravel 13 skeleton generated for TASK-001.
 * Source: sibling directory created by composer create-project.
 */

$root = dirname(__DIR__);
$source = dirname($root) . DIRECTORY_SEPARATOR . '_learnflow_laravel_tmp';

if (! is_dir($source)) {
    fwrite(STDERR, "Source skeleton not found at: {$source}\n");
    exit(1);
}

$preserve = [
    '.cursor',
    'docs',
    'scripts',
    'BUSINESS_FLOW(4).md',
    'CURSOR(2).md',
    'DATABASE(3).md',
    'PRD(4).md',
    'ROADMAP(3).md',
    'SRS(3).md',
    'SYSTEM_DESIGN(4).md',
    'UI_UX(3).md',
    'CURSOR.md',
    'composer.json',
];

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($source, FilesystemIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);

foreach ($iterator as $item) {
    $relative = substr($item->getPathname(), strlen($source) + 1);
    $relative = str_replace('\\', '/', $relative);

  if ($relative === '' || str_starts_with($relative, '.git/')) {
        continue;
    }

    foreach ($preserve as $name) {
        if ($relative === $name || str_starts_with($relative, $name . '/')) {
            continue 2;
        }
    }

    $target = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);

    if ($item->isDir()) {
        if (! is_dir($target)) {
            mkdir($target, 0777, true);
        }
        continue;
    }

    $targetDir = dirname($target);
    if (! is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    copy($item->getPathname(), $target);
}

echo "Imported Laravel skeleton into {$root}\n";
