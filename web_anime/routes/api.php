<?php
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::get('/user', function (Request $request) {
return $request->user();
})->middleware(Authenticate::using('sanctum'));
//posts
Route::apiResource('/list', App\Http\Controllers\Api\AnimeListController::class);
Route::apiResource('/admin', App\Http\Controllers\Api\AdminController::class);
