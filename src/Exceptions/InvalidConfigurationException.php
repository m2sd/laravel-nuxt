<?php

namespace M2S\LaravelNuxt\Exceptions;

use Illuminate\Support\Facades\App;

class InvalidConfigurationException extends \Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        report($this);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        if (App::environment(['local', 'staging']) || config('app.debug')) {
            return response('[Laravel/Nuxt]: '.$this->getMessage(), 404);
        }

        abort(404);
    }
}
