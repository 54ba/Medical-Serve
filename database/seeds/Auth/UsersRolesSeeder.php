<?php

use Illuminate\Database\Seeder;
use App\Models\Auth\User\User;
use App\Models\Auth\Role\Role;
class UsersRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'admin@example.com' => ['administrator', 'authenticated']
        ];

        foreach ($data as $email => $role) {

            $user = User::whereEmail($email)->first();

            if (!$user) continue;

            $role = !is_array($role) ? [$role] : $role;

            $roles = Role::whereIn('name', $role)->get();

            $user->roles()->attach($roles);
        }
    }
}
