<?php

Route::post('warehouse/export/{id}', 'WarehouseController@postExport')->name('warehouse.export');
Route::get('warehouse/item', 'WarehouseController@getItem')->name('warehouse.getItem');
Route::get('warehouse/monitor', 'WarehouseController@showMonitor')->name('warehouse.monitor');
Route::resource('warehouse', 'WarehouseController');