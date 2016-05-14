<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/token/{token}', 'MainController@invitedToken');

Route::group(['middleware' => 'auth'], function() {
    Route::post('/groups/{groups}', 'GroupController@delete');
    Route::post('/tasks/{tasks}', 'TaskController@delete');
    Route::resource('tasks', 'TaskController');
    Route::resource('groups', 'GroupController');

    Route::post('/groups/{members}/delete', [ 'as' => 'groups.membersDelete', 'uses' => 'GroupController@deleteMembers']);
    Route::get('/groups/{group}/addForm', [ 'as' => 'groups.memberAddForm', 'uses' => 'GroupController@memberAddForm']);
    Route::post('/groups/{group}/add', [ 'as' => 'groups.memberAdd', 'uses' => 'GroupController@memberAdd']);

    Route::post('/tasks/{tasks}/add', [ 'as' => 'tasks.commentAdd', 'uses' => 'TaskController@commentAdd']);
    Route::get('/comment/{comment}/edit', [ 'as' => 'tasks.commentEdit', 'uses' => 'TaskController@commentEdit']);
    Route::get('/comment/{comment}/update', [ 'as' => 'tasks.commentUpdate', 'uses' => 'TaskController@commentUpdate']);
    Route::get('/comment/{comment}/delete', [ 'as' => 'tasks.commentDelete', 'uses' => 'TaskController@commentDelete']);

    Route::get('/calendar', 'MainController@calendar');
    Route::get('/calendar/{days}', 'MainController@day');
    
    Route::get('/profile', 'MainController@profile');
    Route::post('/profile/edit', [ 'as' => 'profile.edit', 'uses' => 'MainController@profileEdit']);
    Route::post('/profile/update', [ 'as' => 'profile.update', 'uses' => 'MainController@profileUpdate']);
});