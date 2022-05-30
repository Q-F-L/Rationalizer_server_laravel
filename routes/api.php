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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//регистрация пользователя
Route::post('/register', [UserController::class, 'register']);

//вход в систему
Route::post('/login', [UserController::class, 'login'])->name('login');

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
    
    //изменение статуса проекта
    Route::put('/status/{id}', [ProjectController::class, 'status']);

    //изменение рейтинга проект
    Route::get('/rating/{id}/{rating_get}', [ProjectController::class, 'rating']);

    //изменение rating_calc
    Route::get('/rating_calc/{project_id}', [ProjectController::class, 'rating_calc']);

    //изменение rating_calc
    Route::get('/filter_status/{status}', [ProjectController::class, 'filter_status']);



    //создание сообщения
    Route::post('/create_message', [MessageController::class, 'create']);

    //удаление сообщения
    Route::delete('/delete_message/{user_id}/{id}', [MessageController::class, 'delete']);

    //изменение сообщения
    Route::put('/edit_message/{id}', [MessageController::class, 'edit']);

    Route::get('/get_discussion/{id}', [MessageController::class, 'index']);    

    //поиск пользователя по id (для личного кабинета)
    Route::get('/search/{id}', [UserController::class, 'search']);
});