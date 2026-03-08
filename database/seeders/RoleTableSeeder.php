<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $data = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
            ],
                        [
                'name' => 'Admin',
                'slug' => 'admin',
            ],
            [
                'name' => 'Sales',
                'slug' => 'sales',
            ],
            [
                'name' => 'Support',
                'slug' => 'support',
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager',
            ],
        ];

        foreach ($data as $info) {
            Role::create($info);
        }
    }
}
