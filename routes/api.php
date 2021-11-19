<?php

use App\Http\Controllers\PostsController;
use App\Http\Controllers\SubscribersController;
use App\Http\Controllers\WebsitesController;
use App\Mail\NewPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Process\Process;

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

/**
 * Websites API endpoints
 */
Route::get('/websites', [WebsitesController::class, 'index']);
Route::post('/websites', [WebsitesController::class, 'store']);
Route::get('/websites/{id}', [WebsitesController::class, 'show']);
Route::put('/websites/{id}', [WebsitesController::class, 'update']);
Route::delete('/websites/{id}', [WebsitesController::class, 'destroy']);

/**
 * Posts API endpoints
 */
Route::get('/posts/{websiteId}', [PostsController::class, 'index']);
Route::post('/posts', [PostsController::class, 'store']);
Route::get('/posts/{id}', [PostsController::class, 'show']);
Route::put('/posts/{id}', [PostsController::class, 'update']);
Route::delete('/posts/{id}', [PostsController::class, 'destroy']);

/**
 * Subscribers API endpoints
 */
Route::get('/subscribers', [SubscribersController::class, 'index']);
Route::post('/subscribers', [SubscribersController::class, 'store']);
Route::get('/subscribers/{id}', [SubscribersController::class, 'show']);
Route::put('/subscribers/{id}', [SubscribersController::class, 'update']);
Route::delete('/subscribers/{id}', [SubscribersController::class, 'destroy']);

// Route::get('/send-emails', function(){
//     Artisan::call('queue:work');
// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
