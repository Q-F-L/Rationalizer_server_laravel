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

//вывод проектов с создателем и рейтингом , обсуждения

Route::get('/', function () {

    //Обсужденя
    // $discussions = \App\Models\Discussion::all();

    // foreach ($discussions as $discussion)
    // {
    //     echo '<br>' . '*****************************' . '<br>';
    //     echo 'Discussions = ' . $discussion['title'] . '<br>'; 
    //     foreach ($discussion->message as $message)
    //     {
    //         echo 'User = ' .  $message->user($message['user_id'])['name'] . ' ||||   Message = ' . $message['message'] . "<br>";
    //     }
    // }

    //Рейтинг посчет
    // $projects = \App\Models\Project::all();

    // foreach ($projects as $project)
    // {
    //     echo '<br>' . '*****************************' . '<br>';
    //     echo "{$project['id']} Project =" . $project['title'] . '<br>';
    //     //echo array_sum($project->ratingCalc['rating'])/count($project->ratingCalc['rating']);
    //     $sum = 0;
    //     foreach ($project->ratingCalc as $rating)
    //     {
    //         $sum += $rating->rating;
    //     }
    //     echo round($sum / count($project->ratingCalc), 1);
    // }

    //Пользовател
    $users = \App\Models\User::all();

    foreach ($users as $user)
    {   
        echo '<br>' . '*****************************' . '<br>';
        echo $user->id . '   ';
       echo count($user->rating);
    }
});


