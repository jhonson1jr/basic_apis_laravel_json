<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Rota raiz padrão, apenas para verificação:
    Route::get('/', function () {
        return response()->json(['message' => 'APIs Laravel', 'status' => 'Conectado']);
    });

// Rotas da aplicação:
        Route::get('getinstituicoes', 'ApisController@getInstituicoes');
        Route::get('getconvenios', 'ApisController@getConvenios');
        Route::post('simulacao', 'ApisController@Simulacao');
        