<?php

namespace M2S\LaravelNuxt\Http\Controllers;

use Illuminate\Http\Request;

class NuxtController
{
    /**
     * Handle the SPA request.
     */
    public function __invoke(Request $request): string
    {
        // If the request expects JSON, it means that
        // someone sent a request to an invalid route.
        if ($request->expectsJson()) {
            abort(404);
        }

        return response($this->renderNuxtPage($request))->header('X-Laravel-Nuxt-Proxy', config('app.url'));
    }

    /**
     * Render the Nuxt page.
     */
    protected function renderNuxtPage(Request $request): string
    {
        // If SSR is set to true try to request the full path
        if (config('nuxt.ssr')) {
            return file_get_contents(config('nuxt.ssr').$request->path());
        }

        // In production, this will display the pre-compiled nuxt page.
        // In development, this will fetch and display the page from the nuxt dev server.
        return file_get_contents(config('nuxt.source'));
    }
}
