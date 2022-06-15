<?php

use Illuminate\Support\Facades\Route;

Route::group([

    'middleware' => 'api',

], function ($router) {

    Route::post('getCucuByJenisKelamin', [\App\Http\Controllers\API\SilsilahController::class, 'getCucuByJenisKelamin']);
});
