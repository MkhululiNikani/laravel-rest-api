<?php

use Illuminate\Http\Request;

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

Route::post('/register', 'Auth\RegisterController@create');
Route::post('/login', 'Auth\LoginController@login');
Route::middleware('auth:api')->post('/logout', 'Auth\LoginController@logout');


Route::group([
    'middleware' => 'auth:api'
  ], function() {
    
//USERS
Route::get('/user/{username}', 'UserController@show');
Route::put('/user/{username}', 'UserController@update');       /*controlled*/
Route::patch('/user/{username}', 'UserController@edit');     /*controlled*/
Route::delete('/user/{username}', 'UserController@destroy');    /*controlled*/


//TAGS
Route::post('/tag/{name}', 'TagController@create');


//POSTS
Route::get('/post/{id}', 'PostController@show');
Route::post('/post', 'PostController@create');
Route::put('/post/{id}', 'PostController@update');     /*controlled*/
Route::patch('/post/{id}', 'PostController@edit');   /*controlled*/
Route::delete('/post/{id}', 'PostController@destroy');  /*controlled*/

Route::get('/posts/tag/{name}', 'PostController@postsByTagName'); // all posts with tag{name}
Route::get('/user/{username}/posts', 'PostController@postsByUsername');// all posts by {username}


//COMMENTS
Route::get('/comment/{id}', 'CommentController@show');
Route::get('/post/{id}/comments', 'CommentController@commentsByPostId');
Route::get('/user/{username}/comments', 'CommentController@commentsByUsername');
Route::delete('/comment/{id}', 'CommentController@destroy');    /*controlled*/


//ACTIONS
Route::post('/post/{id}/like', 'PostController@like');
Route::post('/comment/{id}/like', 'CommentController@like');

Route::post('/user/{username}/follow', 'UserController@follow');
Route::post('/user/{username}/unfollow', 'UserController@unfollow');

Route::post('/post/{id}/comment', 'CommentController@store');


//ADMIN -- It's an admin thing, you wouldn't understand
Route::delete('/posts/tag/{name}', 'PostController@destroyByTagName'); // deletes all posts with the tag {name}
Route::delete('/tag/{name}', 'TagController@destroy'); // delete from the tagging table too
Route::get('/users', 'UserController@index');
Route::get('/posts', 'PostController@index');
Route::get('/tags', 'TagController@index');


});