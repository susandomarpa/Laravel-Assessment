<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('auth/github', [App\Http\Controllers\GitHubController::class, 'gitRedirect']);
Route::get('auth/github/callback', [App\Http\Controllers\GitHubController::class, 'gitCallback']);

Route::get('json_file', [ App\Http\Controllers\JsonFileController::class, 'jsonUpload' ])->name('json_file.upload');
Route::post('json_file', [ App\Http\Controllers\JsonFileController::class, 'jsonUploadPost' ])->name('json_file.upload.post');

Route::get('/convert-to-excel/{id}', [App\Http\Controllers\JsonFileController::class, 'convertArrayToSheet'])->name('convertArrayToSheet');
