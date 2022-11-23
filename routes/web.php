<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportController;
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
Route::get('/import', [ImportController::class, 'index']);

Route::post('/import-file', [ImportController::class, 'import'])->name('customer.import');

Route::get('/delete', [ImportController::class, 'delete'])->name('customer.delete');


