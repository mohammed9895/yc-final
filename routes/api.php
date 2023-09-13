<?php

use App\Models\Workshop;
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

Route::get('workshops', function () {
    return Workshop::latest()->where('status', '=', 1)->paginate(10);
});

Route::get('workshops/{workshop}', function (Workshop $workshop) {
    return $workshop->load(['slots', 'place', 'path', 'user']);
});
