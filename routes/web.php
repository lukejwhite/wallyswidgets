<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\WidgetController;

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
    return Inertia::render('Welcome', [
        //removed canLogin and canRegister as I wanted to add an admin area to add and remove packs but ran out of time.
        'canLogin' => false,//Route::has('login'),
        'canRegister' => false//Route::has('register'),
    ]);
});

Route::post('/getWidgets', [ WidgetController::class, 'countWidgets' ]);


