<?php

namespace M2S\LaravelNuxt\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use M2S\LaravelNuxt\Exceptions\InvalidConfigurationException;

class NuxtController
{
    /**
     * Handle the SPA request.
     */
    public function __invoke(Request $request): Response
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
        $source = config('nuxt.source', public_path('spa.html'));

        // If SSR is set to true try to request the path from source URL
        if (config('nuxt.ssr', false) && $this->checkSsrSource($source)) {
            return file_get_contents(rtrim($source, '/').$request->getRequestUri());
        }

        // Return static path resource (URL or file path)
        return file_get_contents(config('nuxt.source'));
    }

    protected function checkSsrSource(string $source): bool
    {
        if (!filter_var($source, FILTER_VALIDATE_URL)) {
            throw new InvalidConfigurationException(sprintf('Found invalid source for ssr mode: %s', $source));
        }

        return true;
    }
}
