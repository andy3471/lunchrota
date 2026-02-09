<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterTeamRequest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class TeamRegistrationController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Brochure/Register');
    }

    public function store(RegisterTeamRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        return DB::transaction(function () use ($request, $validated): RedirectResponse {
            $team = Team::create([
                'name' => $validated['team_name'],
                'slug' => $validated['team_slug'],
            ]);

            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'is_admin' => true,
            ]);

            $team->members()->attach($user);

            Auth::login($user);

            $protocol = $request->secure() ? 'https' : 'http';
            $domain   = config('app.domain');

            return redirect()->away("{$protocol}://{$team->slug}.{$domain}/admin");
        });
    }
}
