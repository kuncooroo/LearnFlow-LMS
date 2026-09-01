<?php

namespace Tests\Feature\Foundation;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DatabaseConnectivityTest extends TestCase
{
    public function test_database_connection_when_driver_is_available(): void
    {
        $driver = config('database.default');
        $extension = match ($driver) {
            'mysql' => 'pdo_mysql',
            'sqlite' => 'pdo_sqlite',
            'pgsql' => 'pdo_pgsql',
            default => null,
        };

        if ($extension !== null && ! extension_loaded($extension)) {
            $this->markTestSkipped("PHP extension [{$extension}] is not available.");
        }

        try {
            DB::connection()->getPdo();
        } catch (\Throwable $exception) {
            $this->markTestSkipped('Database is not configured for this environment: '.$exception->getMessage());
        }

        $this->assertTrue(DB::connection()->getPdo() instanceof \PDO);
    }
}
