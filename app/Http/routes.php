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

Route::get('/calendar', 'MainController@calendar');

Route::get('/calendar/{days}', 'MainController@day');

Route::post('/groups/{members}/delete', [ 'as' => 'groups.membersDelete', 'uses' => 'GroupController@deleteMembers'], function($id) {

});

Route::get('/groups/{members}/addForm', [ 'as' => 'groups.memberAddForm', 'uses' => 'GroupController@memberAddForm']);
Route::post('/groups/{members}/add', [ 'as' => 'groups.memberAdd', 'uses' => 'GroupController@memberAdd']);

Route::group(['middleware' => 'auth'], function() {
    Route::post('/groups/{groups}', 'GroupController@delete');
    Route::post('/tasks/{tasks}', 'TaskController@delete');
    Route::resource('tasks', 'TaskController');
    Route::resource('groups', 'GroupController');
});