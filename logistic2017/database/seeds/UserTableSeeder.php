<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	if(!User::where('username', 'administrator')->count()) {
			$user           = new User;
			$user->username = 'administrator';
			$user->password = \Hash::make('adminpassword');
	        $user->save();
    	}
    }
}
