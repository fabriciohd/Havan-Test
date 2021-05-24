<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    OperationController,
};

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
    return view('home');
})->name('home');

Route::post('/create', [OperationController::class, 'register']);
Route::get('/operations', [OperationController::class, 'getAll'])->name('table');
