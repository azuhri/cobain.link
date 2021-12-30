<?php

use App\Http\Controllers\LinkController;
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
    return redirect()->route("link.random");
});

Route::get('/link/random', function() {
    return view("pages.link-random");
})->name("link.random");

Route::get('/link/custom', function() {
    return view("pages.link-custom");
})->name("link.custom");

Route::post('generate-link', [LinkController::class, 'generateLink'])->name('link.generate');
Route::get('{alias_link}', [LinkController::class, 'aliasLink'])->name('link.alias');
