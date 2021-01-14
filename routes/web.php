<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Models\Lesson;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/bootcamp-courses/{userId}', function($userId) {
    return Lesson::with(['segments','segments.practiceRecords' => function($query) use ($userId){
        $query->where('user_id', '=', $userId);
    }])
        ->where('difficulty', '>=', 1)
        ->get()
        ->toArray();
});
