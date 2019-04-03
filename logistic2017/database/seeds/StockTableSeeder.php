<?php

use Illuminate\Database\Seeder;
use App\Models\Stock;

class StockTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$stockList = [
    		['product_id' => 1, 'user_id' => 1, 'warehouse_id' => 1, 'created_at' => date('Y-m-d H:i:s')],
    		['product_id' => 2, 'user_id' => 1, 'warehouse_id' => 5, 'created_at' => date('Y-m-d H:i:s', strtotime('-27 days'))],
    		['product_id' => 3, 'user_id' => 1, 'warehouse_id' => 6, 'created_at' => date('Y-m-d H:i:s', strtotime('-14 days'))],
    	];
        Stock::insert($stockList);
    }
}
