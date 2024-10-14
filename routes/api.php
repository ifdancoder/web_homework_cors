<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentTypeController;
use App\Http\Controllers\UserController;

Route::controller(UserController::class)->group(function () {
    Route::post('/register', 'create');
    Route::post('/login', 'login');
})->middleware(['guest', 'withoutMiddleware' => 'auth:sanctum']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('equipment-type/without-pagination', [EquipmentTypeController::class, 'indexwp']); // Route, необходимый для правильной работы фронтенда

    Route::apiResources([
        'equipment' => EquipmentController::class,
        'equipment-type' => EquipmentTypeController::class,
    ]);
    
    Route::controller(UserController::class)->group(function () {
        Route::post('/logout', 'logout');
        Route::get('/user', 'user');
    });
});