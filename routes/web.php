<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\DownloadController::class, 'index']);

Route::get('/questoes', [\App\Http\Controllers\DownloadController::class, 'index'])
    ->name('questoes');

Route::get('/listagem', [\App\Http\Controllers\WebServiceController::class, 'index'])
    ->name('listagem');

Route::post('/listagem/adicionar', [\App\Http\Controllers\WebServiceController::class, 'store']);

Route::put('/listagem/adicionar', [\App\Http\Controllers\WebServiceController::class, 'store']);

Route::post('/listagem/editar', [\App\Http\Controllers\WebServiceController::class, 'show'])
    ->name('editar');

Route::delete('/listagem/excluir/{id}', [\App\Http\Controllers\WebServiceController::class, 'destroy']);

Route::post('/questoes/download', [\App\Http\Controllers\DownloadController::class, 'download'])
    ->name('download');

Route::get('/questoes/download', [\App\Http\Controllers\DownloadController::class, 'download'])
    ->name('downloadGet');

