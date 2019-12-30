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
Route::group([
    'middleware' => 'auth:api'
  ], function() {
    Route::post('/logout', 'Auth\LoginController@logout');
  });


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//USERS
Route::get('/user/{username}', 'UserController@index');
Route::put('/user/{username}', 'UserController@index');       /*controlled*/
Route::patch('/user/{username}', 'UserController@index');     /*controlled*/
Route::delete('/user/{username}', 'UserController@index');    /*controlled*/


//TAGS
Route::post('/tag/{name}', 'TagController@index');


//POSTS
Route::get('/post/{id}', 'PostController@index');
Route::post('/post', 'PostController@index');
Route::put('/post/{id}', 'PostController@index');     /*controlled*/
Route::patch('/post/{id}', 'PostController@index');   /*controlled*/
Route::delete('/post/{id}', 'PostController@index');  /*controlled*/

Route::get('/posts/tag/{name}', 'PostController@index'); // all posts with tag{name}
Route::get('/user/{username}/posts', 'PostController@index');// all posts by {username}


//COMMENTS
Route::get('/comment/{id}', 'CommentController@index');
Route::get('/post/{id}/comments', 'CommentController@index');
Route::get('/user/{username}/comments', 'CommentController@index');
Route::delete('/comment/{id}', 'CommentController@index');    /*controlled*/


//ACTIONS
Route::post('/post/{id}/like', 'PostController@index');
Route::post('/comment/{id}/like', 'CommentController@index');

Route::post('/user/{username}/follow', 'UserController@index');
Route::post('/user/{username}/unfollow', 'UserController@index');

Route::post('/post/{id}/comment', 'CommentController@index');


//ADMIN -- It's an admin thing, you wouldn't understand
Route::delete('/posts/tag/{name}', 'PostController@index'); // deletes all posts with the tag {name}
Route::delete('/tag/{name}', 'TagController@index'); // delete from the tagging table too
Route::get('/users', 'UserController@index');
Route::get('/posts', 'PostController@index');
Route::get('/tags', 'TagController@index');