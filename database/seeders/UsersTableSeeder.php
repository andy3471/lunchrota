<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\LunchSlot;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $team = Team::factory()->create([
            'name'                   => 'Demo Team',
            'slug'                   => 'demo',
            'register_enabled'       => true,
            'reset_password_enabled' => false,
            'roles_enabled'          => true,
            'lunch_slot_calculated'  => false,
            'default_role'           => 'In Office',
        ]);

        // Create admin user and attach to team
        $admin = User::factory()->admin()->create([
            'email' => 'admin@admin.com',
        ]);
        $admin->teams()->attach($team);

        // Create regular users and attach to team
        $users = User::factory(10)->create();
        $team->members()->attach($users);

        // Create default roles for the team
        Role::create(['name' => 'In Office', 'is_available' => true, 'team_id' => $team->id]);
        Role::create(['name' => 'Working From Home', 'is_available' => false, 'team_id' => $team->id]);
        Role::create(['name' => 'Annual Leave', 'is_available' => false, 'team_id' => $team->id]);

        // Create default lunch slots for the team
        LunchSlot::create(['time' => '12:00', 'available' => 3, 'team_id' => $team->id]);
        LunchSlot::create(['time' => '12:30', 'available' => 3, 'team_id' => $team->id]);
        LunchSlot::create(['time' => '13:00', 'available' => 3, 'team_id' => $team->id]);
    }
}
