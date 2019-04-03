<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
        	['name' => 'admin'],
        ];

        $datetime = date('Y-m-d H:i:s');
        array_walk($roles, function(&$value, $key) use ($datetime) {
        	$value['created_at'] = $datetime;
        	$value['updated_at'] = $datetime;
        });

        Role::insert($roles);
    }
}
