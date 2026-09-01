<?php

namespace Tests\Feature\Foundation;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_home_page_renders_successfully(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('LearnFlow LMS');
        $response->assertSee('Project Foundation');
    }
}
