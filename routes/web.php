<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntityController;

Route::post('/extract-entities', [EntityController::class, 'extractEntities']);

Route::get('/', function () {
    return view('extract_entities'); // Asegúrate de que esta vista exista en resources/views
});
