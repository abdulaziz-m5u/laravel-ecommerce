<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeedPivot extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            
            1 => [
                'permissions' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40],
            ],
            2 => [
                'permissions' => [1],
            ],

        ];

        foreach ($permissions as $id => $permission) {
            $role = Role::find($id);

            foreach ($permission as $key => $ids) {
                $role->{$key}()->sync($ids);
            }
        }
    }
}
