<?php

use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$warehouseList = [
    		['x' => 0, 'y' => 1, 'z' => 1],
    		['x' => 0, 'y' => 2, 'z' => 1],
    		['x' => 0, 'y' => 3, 'z' => 1],
    	];

        $datetime = date('Y-m-d H:i:s');
        array_walk($warehouseList, function(&$value, $key) use ($datetime) {
            $value['created_at'] = $datetime;
            $value['updated_at'] = $datetime;
        });
        Warehouse::insert($warehouseList);
    }
}
