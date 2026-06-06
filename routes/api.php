<?php

use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

Route::post('/links', [UrlController::class, 'store']);
Route::get('/links/{code}/stats', [UrlController::class, 'stats']);