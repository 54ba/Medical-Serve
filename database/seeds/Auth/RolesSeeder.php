<?php

use Illuminate\Database\Seeder;
use App\Models\Auth\Role\Role;
class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [['name' => 'administrator'], ['name' => 'authenticated']];
        Role::insert($roles);

    }
}
