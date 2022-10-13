<?php

use App\Models\App;
use Illuminate\Support\Facades\Request;

if (! function_exists('application')) {
    function application()
    {
        return App::where('app_token', Request::header('APP-TOKEN'))->first();
    }
}
