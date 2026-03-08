<?php

namespace Database\Seeders;

use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleTableSeeder::class);

        $role = Role::where('name', '=', 'Super Admin')->first();
        $role->permissions()->sync(Permission::get()->pluck('id'));

        User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'], // check by email
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'password' => bcrypt('123456'),
                'email_verified_at' => Carbon::now(),
                'role_id' => $role->id,
                'status' => 'active'
            ]
        );
        
        // $this->call(CountrySeeder::class);
    }
}
