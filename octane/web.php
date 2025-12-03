<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

use Swoole\Coroutine;

Route::get('/', function (Request $req) {
    $delay = (int) $req->query('delay', 0);

    if ($delay > 0) {
        Coroutine::sleep($delay);
    }

    return response()->json(['delay' => $delay]);
});

Route::get('/stream', function (Request $req) {
    $data =['id,name', '1,Alice', '2,Bob', '3,Charlie', '4,David', '5,Eve'];

    return response()->stream(function () use ($data) {
        foreach ($data as $line) {
            sleep(5);
            echo $line . PHP_EOL;

            if (function_exists('ob_get_level') && ob_get_level() > 0) {
                ob_flush();
            }

            if (function_exists('flush')) {
                flush();
            }
        }
    }, 200, [
        'Cache-Control' => 'no-store, no-cache, must-revalidate',
        'Content-Type' => 'text/csv; charset=UTF-8',
        'Pragma' => 'no-cache',
        'Transfer-Encoding' => 'chunked',
        'X-Accel-Buffering' => 'no', // Disable Nginx buffering
    ]);
});