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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// API LEVEL
$router->get('/level', ['uses' => 'MasterLevelController@index']);
$router->get('/level/{id}', ['uses' => 'MasterLevelController@index']);
$router->post('/level', ['uses' => 'MasterLevelController@store']);
$router->put('/level/{id}', ['uses' => 'MasterLevelController@update']);
$router->delete('/level/{id}', ['uses' => 'MasterLevelController@destroy']);
// API USERS
$router->get('/user', ['uses' => 'UserController@index']);
$router->get('/user/{id}', ['uses' => 'UserController@index']);
// $router->put('/user/{id}', ['uses' => 'UserController@update']);
$router->delete('/user/{id}', ['uses' => 'UserController@destroy']);
// API AUTH
$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('register', ['uses' => 'AuthController@register']);
    $router->post('login', ['uses' => 'AuthController@login']);
    // $router->post('logout', ['uses' => 'AuthController@logout']);
});
// API INFORMATION
$router->get('/information', ['uses' => 'InformationController@index']);
$router->get('/information/{id}', ['uses' => 'InformationController@index']);
$router->post('/information', ['uses' => 'InformationController@store']);
$router->post('/information/{id}', ['uses' => 'InformationController@update']);
$router->delete('/information/{id}', ['uses' => 'InformationController@destroy']);
// API LEVEL
$router->get('/type-letter', ['uses' => 'TypeLetterController@index']);
$router->get('/type-letter/{id}', ['uses' => 'TypeLetterController@index']);
$router->post('/type-letter', ['uses' => 'TypeLetterController@store']);
$router->put('/type-letter/{id}', ['uses' => 'TypeLetterController@update']);
$router->delete('/type-letter/{id}', ['uses' => 'TypeLetterController@destroy']);
// API LETTER SUBMISSION
$router->get('/letter-submission', ['uses' => 'LetterSubmissionController@index']);
$router->get('/letter-submission/{id}', ['uses' => 'LetterSubmissionController@index']);
$router->post('/letter-submission', ['uses' => 'LetterSubmissionController@store']);
$router->put('/letter-submission/{id}', ['uses' => 'LetterSubmissionController@update']);
$router->delete('/letter-submission/{id}', ['uses' => 'LetterSubmissionController@destroy']);
// API PATROLI SCHEDULE
$router->get('/patroli-schedule', ['uses' => 'PatroliScheduleController@index']);
$router->get('/patroli-schedule/{id}', ['uses' => 'PatroliScheduleController@index']);
$router->post('/patroli-schedule', ['uses' => 'PatroliScheduleController@store']);
$router->put('/patroli-schedule/{id}', ['uses' => 'PatroliScheduleController@update']);
$router->delete('/patroli-schedule/{id}', ['uses' => 'PatroliScheduleController@destroy']);
// API FAQ
$router->get('/faq', ['uses' => 'FaqController@index']);
$router->get('/faq/{id}', ['uses' => 'FaqController@index']);
$router->post('/faq', ['uses' => 'FaqController@store']);
$router->put('/faq/{id}', ['uses' => 'FaqController@update']);
$router->delete('/faq/{id}', ['uses' => 'FaqController@destroy']);