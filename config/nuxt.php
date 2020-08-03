<?php

return [
    'routing' => true,
    'prefix'  => 'app',
    'source'  => env('NUXT_OUTPUT_PATH', public_path('spa.html')),
    'ssr'     => env('NUXT_SSR_PROXY', false),
];
