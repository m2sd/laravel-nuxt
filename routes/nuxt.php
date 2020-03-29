<?php

use M2S\LaravelNuxt\Facades\Nuxt;

Nuxt::route('{path?}')->name('nuxt')->where('path', '.*');
