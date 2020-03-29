# NuxtJS for Laravel

This package facilitates integrating an SPA built with NuxtJS into an existing Laravel project.

## Installation

```sh
composer require m2s/laravel-nuxt
```

After installation you can publish the config.

```sh
php artisan vendor:publish --provider="M2S\LaravelNuxt\LaravelNuxtServiceProvider"
```

## Setup

The package provides a command for easy installation and integration of a nuxt project.

```sh
$ php artisan nuxt:install -h
Description:
  Create a new nuxt project or setup integration of an existing one

Usage:
  nuxt:install [options] [--] [<source>]

Arguments:
  source                 Root folder of the nuxt application [default: "resources/nuxt"]

Options:
  -y, --yarn             Use yarn package manager
  -t, --typescript       Use typescript runtime
  -p, --prefix[=PREFIX]  Prefix for the nuxt application [default: "app"]
  -c, --cache[=CACHE]    Optional caching endpoint (e.g. /api/cache)
      --no-export        Do not export env variable on build
  -h, --help             Display this help message
  -q, --quiet            Do not output any message
  -V, --version          Display this application version
      --ansi             Force ANSI output
      --no-ansi          Disable ANSI output
  -n, --no-interaction   Do not ask any interactive question
      --env[=ENV]        The environment the command should run under
  -v|vv|vvv, --verbose   Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
```

## Automatic routing

By default the package automatically adds a route for nuxt pages.

`config('nuxt.prefix').'/{path?}'`

This route is named `'nuxt'` and can be used to redirect to using Laravels route helper.

```php
route('nuxt');

// or

route('nuxt', ['path' => 'some/deep/path']);
```

You can disable/enable automatic routing with the `'routing'` setting in `config/nuxt.php`.

## Manual Routing

If you would like to manually define routes for nuxt you can use the included Controller.

```php

use M2S\LaravelNuxt\Http\Controllers\NuxtController;

// Be sure to use the defined 'prefix', as nuxt uses this internally for route resolution
Route::get('app/example/route', NuxtController::class);
```
