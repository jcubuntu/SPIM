<?php

use App\Models\Item;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('stockin', function(Request $request) {
    $product = Product::where('RFID', $request->input('rfid'))->first();
    if($product) {
        $warehouseList = Warehouse::orderBy('y')->get();
        foreach($warehouseList as $warehouse) {
            if(!$warehouse->getItemInStock()) {
                $item               = new Item;
                $item->product_id   = $product->id;
                $item->warehouse_id = $warehouse->id;
                $item->status       = Item::STATUS_IN_WAREHOUSE;
                $item->save();

                $returnData = $warehouse->getWarehouseInfo();
                //$returnData['str'] = "i{$warehouse->x}{$warehouse->y}{$warehouse->z}";
                $returnData['str'] = "i{$warehouse->x}{$warehouse->y}z";

                return $returnData;
            }
        }
        return 0;
    }
    return 0;
});