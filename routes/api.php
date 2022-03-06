<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\DiscussionController;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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
Route::post('/login', [UserController::class, 'login'])->name('login');

//выход из системы


//возможности доступные только авторизованным пользователям
Route::middleware('authtoken')->group(function () {

    //создание проекта и создание обсуждения
    Route::post('/create_project', [ProjectController::class, 'create']);

    //вывести все проекты
    Route::get('/all_project', [ProjectController::class, 'index']);

    //поиск проекта по id
    Route::get("/search_id_project/{id}", [ProjectController::class, 'search']);

    //поиск проекта по имени
    Route::get("/search_name_project/{title}", [ProjectController::class, 'searchName']);

    //удалить свой проект
    Route::delete('/delete_project/{id}', [ProjectController::class, 'delete']);

    //изменение проект
    Route::put('/edit_project/{id}', [ProjectController::class, 'edit']);

    //создание сообщения
    Route::post('/create_message', [MessageController::class, 'create']);

    //удаление сообщения
    Route::delete('/delete_message/{user_id}/{id}', [MessageController::class, 'delete']);

    //изменение сообщения
    Route::put('/edit_message/{id}', [MessageController::class, 'edit']);

    //поиск пользователя по id (для личного кабинета)
    Route::get('/search/{id}', [UserController::class, 'search']);
});

//повозможности (желательно)
//возможности админа

    //удаление обсуждения

    //удаление пользователя

