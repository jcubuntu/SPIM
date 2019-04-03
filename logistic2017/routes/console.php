<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('make:route {routeName} {--c}', function ($routeName) {
	if(Storage::disk('route')->exists("web/{$routeName}.php")) {
		return $this->info('Route "'.$routeName.'" is already !');
	}

	$php = ['<?php', ''];

	if(!$this->option('c')) {
		$php[] = "Route::get('{$routeName}', ['as' => '{$routeName}', function() {".PHP_EOL.PHP_EOL."}]);";

	} else {
		$controllerName = ucfirst($routeName).'Controller';

		if(!Storage::exists('Http/Controllers/'.$controllerName.'.php')) {
			$php[] = "Route::resource('{$routeName}', '{$controllerName}');";
			$this->call('make:controller', ['name' => $controllerName]);
		} else {
			$this->info('Controller "'.$controllerName.'" is already !');
		}
	}

	Storage::disk('route')->put("web/{$routeName}.php", implode(PHP_EOL, $php));
	$this->info('Success !');

});

Artisan::command('git {name?}', function ($name='update') {
    $path = base_path();
    exec("cd $path", $output);
    exec("git add -A", $output);
    exec("git commit -m \"{$name}\"", $output);
    exec("git push origin master", $output);

    $this->line($name.' Uploaded');
    foreach ($output as $line) {
        $this->line("$line");
    }
});
