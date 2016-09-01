<?php

App\Http\Controllers\HomeController::routes();

Route::get('/vuevue', function ()
{
	return View::make('vuevue');
});