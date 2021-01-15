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
use Illuminate\Database\Eloquent\Relations\HasMany;

$router->get('/', fn() => $router->app->version());

$router->get('/student-progress/{userId}', function(int $userId) {
    return Lesson::with(['segments','segments.practiceRecords' => function(HasMany $query) use ($userId) {
        $query->where('user_id', $userId);
    }])
        ->where('is_published',true)
        ->get()
        ->toArray();
});
