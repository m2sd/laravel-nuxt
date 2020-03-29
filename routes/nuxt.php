<?php

use Illuminate\Support\Facades\Route;
use M2S\LaravelNuxt\Http\Controllers\NuxtController;

$prefix = rtrim(config('nuxt.prefix'), '/');

Route::get(
    "$prefix/{path?}",
    NuxtController::class
)->name('nuxt')->where('path', '.*');
