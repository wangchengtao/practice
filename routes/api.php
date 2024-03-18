<?php

use App\Http\Controllers\AuthController;
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
Route::apiResource('users', UserController::class)->except(['destroy']);

Route::post('topics/{topic}/replies', [ReplyController::class, 'store'])->name('replies.store');
Route::get('replies/{reply}', [ReplyController::class, 'show'])->name('replies.show');
Route::put('replies/{reply}', [ReplyController::class, 'update'])->name('replies.update');
Route::delete('replies/{reply}', [ReplyController::class, 'destroy'])->name('replies.destroy');

Route::prefix('auth')->group(function () {
    Route::post('/', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/me', [AuthController::class, 'me'])->name('auth.me');
    Route::delete('/', [AuthController::class, 'logout'])->name('auth.logout');
    Route::patch('password', [AuthController::class, 'modifyPassword'])->name('auth.modify-password');
});

