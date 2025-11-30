<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

use Swoole\Coroutine;

Route::get('/', function (Request $req) {
    $delay = (int) $req->query('delay', 0);

    if ($delay > 0) {
        sleep($delay);
    }

    return response()->json(['delay' => $delay]);
});
