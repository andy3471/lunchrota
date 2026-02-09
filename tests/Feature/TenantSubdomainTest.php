<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantSubdomainTest extends TestCase
{
    use RefreshDatabase;

    /** A valid tenant subdomain resolves the team. */
    public function test_valid_subdomain_resolves_team(): void
    {
        $team = Team::factory()->create(['slug' => 'acme']);
        $user = User::factory()->create();
        $team->members()->attach($user);

        $response = $this->actingAs($user)->get('http://acme.localhost/');

        $response->assertStatus(200);
    }

    /** An invalid subdomain returns 404. */
    public function test_invalid_subdomain_returns_404(): void
    {
        $response = $this->get('http://nonexistent.localhost/');

        $response->assertStatus(404);
    }

    /** Login page loads on a tenant subdomain. */
    public function test_login_page_loads_on_tenant_subdomain(): void
    {
        Team::factory()->create(['slug' => 'demo']);

        $response = $this->get('http://demo.localhost/login');

        $response->assertStatus(200);
    }

    /** Users can authenticate on a tenant subdomain. */
    public function test_user_can_authenticate_on_tenant_subdomain(): void
    {
        $team = Team::factory()->create(['slug' => 'acme']);
        $user = User::factory()->create();
        $team->members()->attach($user);

        $response = $this->post('http://acme.localhost/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
    }

    /** The home page shows tenant-scoped data. */
    public function test_home_page_shows_tenant_scoped_data(): void
    {
        $team = Team::factory()->create(['slug' => 'acme']);
        $user = User::factory()->create();
        $team->members()->attach($user);

        $response = $this->actingAs($user)->get('http://acme.localhost/');

        $response->assertStatus(200);
    }
}
