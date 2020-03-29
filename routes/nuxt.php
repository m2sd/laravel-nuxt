<?php

use Illuminate\Support\Facades\Route;
use M2S\LaravelNuxt\Http\Controllers\NuxtController;

Route::get(
    trim(config('nuxt.prefix'), '/').'/{path?}',
    NuxtController::class
)->name('nuxt')->where('path', '.*');
