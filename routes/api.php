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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//USERS
Route::get('/user/{username}', 'UserController');
Route::put('/user/{username}', 'UserController');       /*controlled*/
Route::patch('/user/{username}', 'UserController');     /*controlled*/
Route::delete('/user/{username}', 'UserController');    /*controlled*/


//TAGS
Route::post('/tag/{name}', 'TagController');


//POSTS
Route::get('/post/{id}', 'PostController');
Route::post('/post', 'PostController');
Route::put('/post/{id}', 'PostController');     /*controlled*/
Route::patch('/post/{id}', 'PostController');   /*controlled*/
Route::delete('/post/{id}', 'PostController');  /*controlled*/

Route::get('/posts/tag/{name}', 'PostController'); // all posts with tag{name}
Route::get('/user/{username}/posts', 'PostController');// all posts by {username}


//COMMENTS
Route::get('/comment/{id}', 'CommentController');
Route::get('/post/{id}/comments', 'CommentController');
Route::get('/user/{username}/comments', 'CommentController');
Route::delete('/comment/{id}', 'CommentController');    /*controlled*/


//ACTIONS
Route::post('/post/{id}/like', 'PostController');
Route::post('/comment/{id}/like', 'CommentController');

Route::post('/user/{username}/follow', 'UserController');
Route::post('/user/{username}/unfollow', 'UserController');

Route::post('/post/{id}/comment', 'CommentController');


//ADMIN -- It's an admin thing, you wouldn't understand
Route::delete('/posts/tag/{name}', 'PostController'); // deletes all posts with the tag {name}
Route::delete('/tag/{name}', 'TagController'); // delete from the tagging table too
Route::get('/users', 'UserController');
Route::get('/posts', 'PostController');
Route::get('/tags', 'TagController');