<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\CashRegisterController;
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

Route::post('cargarBaseCaja', [ApiController::class, 'loadBoxBase']);
Route::post('vaciarCaja', [ApiController::class, 'emptyBox']);
Route::get('estadoCaja', [ApiController::class, 'boxBaseForTypeMoney']);
Route::post('realizarPago', [ApiController::class, 'paymentsRegister']);
