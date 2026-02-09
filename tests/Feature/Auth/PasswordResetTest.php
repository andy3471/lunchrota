<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    private Team $team;

    protected function setUp(): void
    {
        parent::setUp();

        $this->team = Team::factory()->create(['slug' => 'test']);
    }

    /** Reset password link screen can be rendered when enabled. */
    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        if (! config('app.reset_password_enabled')) {
            $this->markTestSkipped('Password reset is disabled.');
        }

        $response = $this->get('http://test.localhost/forgot-password');

        $response->assertStatus(200);
    }

    /** Reset password link can be requested when enabled. */
    public function test_reset_password_link_can_be_requested(): void
    {
        if (! config('app.reset_password_enabled')) {
            $this->markTestSkipped('Password reset is disabled.');
        }

        Notification::fake();

        $user = User::factory()->create();
        $this->team->members()->attach($user);

        $this->post('http://test.localhost/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class);
    }
}
