<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('categories', CategoryController::class);
Route::apiResource('topics', TopicController::class);

Route::post('topics/{topic}/replies', [ReplyController::class, 'store'])->name('replies.store');
Route::get('replies/{reply}', [ReplyController::class, 'show'])->name('replies.show');
Route::put('replies/{reply}', [ReplyController::class, 'update'])->name('replies.update');
Route::delete('replies/{reply}', [ReplyController::class, 'destroy'])->name('replies.destroy');

Route::apiResource('users', UserController::class)->except(['destroy']);
// Route::post('users', [UserController::class, 'store'])->name('users.store');
// Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
// Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
// Route::get('users', [UserController::class, 'index'])->name('users.index');
