<?php

use M2S\LaravelNuxt\Facades\Nuxt;

Nuxt::route('{path?}')->middleware('web')->name('nuxt')->where('path', '.*');
