<?php

namespace Tests\Feature\Foundation;

use Tests\TestCase;

class ApplicationBootTest extends TestCase
{
    public function test_application_boots(): void
    {
        $this->assertSame('testing', app()->environment());
        $this->assertNotEmpty(config('app.name'));
    }
}
