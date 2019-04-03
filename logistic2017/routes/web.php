<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

$exceptFile = [];
$files = File::allFiles(base_path('routes/web'));

foreach($files as $file) {
	if(!in_array($file->getFileName(), $exceptFile))
		include $file->getPathName();
}