<?php

use App\Http\Controllers\Api\MenuController;
use Illuminate\Support\Facades\Route;
Route::prefix("v1/menus")->middleware('web')->group(function () {
    Route::get('', [MenuController::class, 'index']);
});


