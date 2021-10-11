<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WebSiteController;
use App\Models\Category;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/article', [ArticleController::class, 'index']);
Route::get('/article/search', [ArticleController::class, 'search']);
Route::get('/article/website/{webSiteToken}', [ArticleController::class, 'getByWebSite']);
Route::get('/article/category/{categoyToken}', [ArticleController::class, 'getByCategory']);
Route::get('/article/{token}', [ArticleController::class, 'show']);
// Route::post('/article', [ArticleController::class, 'store']);
Route::match(['put', 'patch'], 'article/{token}', [ArticleController::class, 'update']);
Route::delete('/article/{token}', [Articlecontroller::class, 'destroy']);


Route::get('/category', [CategoryController::class, 'index']);
Route::get('/category/{token}', [CategoryController::class, 'show']);
Route::post('/category', [CategoryController::class, 'store']);
Route::match(['put', 'patch'], 'category/{token}', [CategoryController::class, 'update']);
Route::delete('/category/{token}', [Categorycontroller::class, 'destroy']);

Route::get("website", [WebSiteController::class, 'index']);
Route::get('/website/{token}', [WebSiteController::class, 'show']);
Route::post('/website', [WebSiteController::class, 'store']);
Route::match(['put', 'patch'], '/website/{token}', [WebSiteController::class, 'update']);
Route::delete('/website/{token}', [WebSitecontroller::class, 'destroy']);


// Route::apiResource('article', ArticleController::class);
// Route::apiResource('website', WebSiteController::class);
// Route::apiResource('category', CategorieController::class);
