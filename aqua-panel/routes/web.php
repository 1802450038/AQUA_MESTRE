<?php

use App\Http\Controllers\BoardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

