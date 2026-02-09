<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /** The brochure landing page loads on the main domain. */
    public function test_brochure_landing_page_loads(): void
    {
        $response = $this->get('http://localhost/');

        $response->assertStatus(200);
    }

    /** The team registration page loads on the main domain. */
    public function test_team_registration_page_loads(): void
    {
        $response = $this->get('http://localhost/register');

        $response->assertStatus(200);
    }
}
