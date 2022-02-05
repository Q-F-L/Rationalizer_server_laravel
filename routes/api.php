<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//регистрация пользователя
Route::post('/register', [UserController::class, 'register']);

//вход в систему
Route::post('/login', [UserController::class, 'login']);

//выход из системы
// Route::post('/logout', [UserController::class, 'logout']);


//возможности доступные только авторизованным пользователям

    //создание проекта

    //создание обсуждения

    //создание сообщения


//повозможности (желательно)
//возможности админа

    //удаление обсуждения

    //удаление пользователя

