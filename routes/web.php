<?php

use App\Utils\Util;

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
$router->get('/', function () {
    return response()->json(['status' => true]);
});

$router->get('/balance',  ['uses' => 'AccountController@balance']);
$router->post('/event',  ['uses' => 'EventController@event']);
$router->post('/reset',  function () {
    (new Util)->resetDb();
    return response('OK');
}); 