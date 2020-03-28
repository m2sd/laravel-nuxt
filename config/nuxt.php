<?php

return [
    'defaultRoute' => true,
    'prefix'       => '/app/',
    'source'       => env('NUXT_OUTPUT_PATH', public_path('spa.html')),
];
