<?php

namespace Tests\Concerns;

trait RequiresDatabase
{
    protected function skipIfDatabaseUnavailable(): void
    {
        $driver = getenv('DB_CONNECTION') ?: 'sqlite';
        $extension = match ($driver) {
            'mysql' => 'pdo_mysql',
            'sqlite' => 'pdo_sqlite',
            'pgsql' => 'pdo_pgsql',
            default => null,
        };

        if ($extension !== null && ! extension_loaded($extension)) {
            $this->markTestSkipped("PHP extension [{$extension}] is not available.");
        }
    }
}
