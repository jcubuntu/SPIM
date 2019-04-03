<?php

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$userAdmin = User::where('username', 'administrator')->first();
    	$roleAdmin = Role::where('name', 'admin')->first();
    	if($userAdmin && $userAdmin) {
        	RoleUser::insert(['user_id' => $userAdmin->id, 'role_id' => $roleAdmin->id]);
    	}
    }
}
