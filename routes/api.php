<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\VideosController;



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

Route::prefix('usuarios')->group(function(){
    Route::put('/crear',[UsuariosController::class,'crear']);
    Route::post('/desactivar/{id}',[UsuariosController::class,'desactivar']);
    Route::post('/editar/{id}',[UsuariosController::class,'editar']);
    Route::get('/ver/{id}',[UsuariosController::class,'ver']);
    Route::put('/comprar_curso/{curso_id}/{usuario_id}',[UsuariosController::class,'comprar_curso']);
    Route::get('/adquiridos/{usuario_id}',[UsuariosController::class,'adquiridos']);
 });


Route::prefix('cursos')->group(function(){
    Route::put('/crear',[CursosController::class,'crear']);
    Route::get('/listar',[CursosController::class,'listar']);
    Route::get('/ver/{id}',[CursosController::class,'ver']);
 });


 Route::prefix('videos')->group(function(){
    Route::put('/crear',[VideosController::class,'crear']);
    Route::get('/listar',[VideosController::class,'listar']);
    Route::get('/ver/{id}',[VideosController::class,'ver']);
 });
