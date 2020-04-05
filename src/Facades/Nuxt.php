<?php

namespace M2S\LaravelNuxt\Facades;

use Illuminate\Support\Facades\Route;
use M2S\LaravelNuxt\Http\Controllers\NuxtController;

class Nuxt
{
    public static function route(string $path)
    {
        return Route::get(
            '/'.trim(config('nuxt.prefix'), '/').'/'.trim($path, '/'),
            '\\'.NuxtController::class
        );
    }
}
