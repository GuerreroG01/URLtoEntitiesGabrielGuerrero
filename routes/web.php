<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntityController;

Route::post('/extract-entities', [EntityController::class, 'extractEntities']);

Route::get('/', function () {
    return view('index');
});
