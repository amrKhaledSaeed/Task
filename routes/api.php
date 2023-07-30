<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\TagsController;
use App\Http\Controllers\Api\V1\RegisterController;

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
Route::post('register',[RegisterController::class,'register']);
Route::post('login',[RegisterController::class,'login']);
Route::middleware('auth:sanctum')->group(function () {
   // return $request->user();
   Route::apiResource('tags',TagsController::class);
   Route::apiResource('posts',PostController::class);
   Route::get('viewDeletedPosts',[PostController::class,'viewDeletedPosts']);
   Route::get('restoreDeletedPosts/{id}',[PostController::class,'restoreDeletedPosts']);
});
