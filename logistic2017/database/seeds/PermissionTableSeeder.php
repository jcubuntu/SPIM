<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$datetime = date('Y-m-d H:i:s');
        $permissions = [
        	['name' => 'manage.account'],
        	['name' => 'manage.warehouse'],
        	['name' => 'manage.product'],
        	['name' => 'manage.queue'],
        	['name' => 'dashboard'],
        ];

        array_walk($permissions, function(&$value, $key) use ($datetime) {
        	$value['created_at'] = $datetime;
        	$value['updated_at'] = $datetime;
        });

        Permission::insert($permissions);
    }
}
