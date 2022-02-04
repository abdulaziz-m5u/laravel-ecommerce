<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id'    => 1,
                'title' => 'admin',
            ],
            [
                'id'    => 2,
                'title' => 'user',
            ],
        ];

        Role::insert($roles);
    }
}
