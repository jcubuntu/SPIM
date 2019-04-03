<?php

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productList = [
        	['RFID' => '6911249101210', 'name' => 'มาม่าต้มยำกุ้ง', 'deadstock' => 7],
        	['RFID' => '6975179107214', 'name' => 'ไวตามิ้ลค์', 'deadstock' => 15],
        	['RFID' => '37443711991', 'name' => 'ปาปีก้า', 'deadstock' => 30],
        ];

        $datetime = date('Y-m-d H:i:s');
        array_walk($productList, function(&$value, $key) use ($datetime) {
            $value['created_at'] = $datetime;
            $value['updated_at'] = $datetime;
        });

        Product::insert($productList);
    }
}
