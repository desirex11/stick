<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Events\PlayerMoved;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/test-broadcast', [GameController::class, 'testBroadcast']);