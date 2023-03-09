<?php

use App\Http\Controllers\HearingTestController;
use App\Http\Controllers\HearingTestResultController;
use App\Http\Controllers\SoundController;
use App\Http\Controllers\TestConfgurationController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('ear',[TestConfgurationController::class,'store']);
Route::post('sound-frequency',[TestConfgurationController::class,'storeSoundFrequency']);
Route::post('birth-year',[TestConfgurationController::class,'storeBirthyear']);
Route::post('Sound',[SoundController::class,'index']);
Route::post('attempt-test',[HearingTestController::class,'store']);
Route::post('complete-test',[HearingTestResultController::class,'store']);

