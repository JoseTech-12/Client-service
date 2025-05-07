<?php

use App\Http\Controllers\ClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/clients', [ClientController::class, 'index'])->name('clients');
Route::post('/createClient', [ClientController::class, 'store'])->name('createClient');
Route::get('/showClient/{id}', [ClientController::class, 'show'])->name('showClient');
Route::put('/updateClient/{id}', [ClientController::class, 'update'])->name('updateClient');
Route::delete('deleteClient/{id}', [ClientController::class, 'destroy'])->name('deleteClient');
