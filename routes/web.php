<?php

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

Route::get('/', 'HomeController@index')->name('home');

// Route::get('/alert', function () {
//     return redirect()->route('home')->with('info', 'Вы можете войти!');
// });

/**
 * Авторизация
 */

Route::get('/signup', 'AuthController@getSignUp')->middleware('guest')->name('auth.signup');
Route::post('/signup', 'AuthController@postSignUp')->middleware('guest');

Route::get('/signin', 'AuthController@getSignIn')->middleware('guest')->name('auth.signin');
Route::post('/signin', 'AuthController@postSignIn')->middleware('guest');

Route::get('/signout', 'AuthController@signOut')->name('auth.signout');

/**
 * Поиск
 */

Route::get('/search', 'SearchController@getResults')->name('search.results');

/**
 * Профили
 */

Route::get('/user/{username}', 'ProfileController@getProfile')->name('profile.index');

Route::middleware(['auth', 'verified'])->prefix('profile')->name('profile.')->group(function () {
    Route::get('/edit', 'ProfileController@getEdit')->name('edit');
    Route::post('/edit', 'ProfileController@postEdit')->name('edit');
    Route::post('/upload-avatar/{username}', 'ProfileController@postUploadAvatar')->name('upload-avatar');
});

/**
 * Друзья
 */

Route::middleware(['auth', 'verified'])->prefix('friends')->name('friend.')->group(function () {
    Route::get('/', 'FriendController@getIndex')->name('index');
    Route::get('/add/{username}', 'FriendController@getAdd')->name('add');
    Route::get('/accept/{username}', 'FriendController@getAccept')->name('accept');
    Route::post('/delete/{username}', 'FriendController@postDelete')->name('delete');
});

/**
 * Стена
 */
Route::middleware(['auth', 'verified'])->prefix('status')->name('status.')->group(function () {
    Route::post('/', 'StatusController@PostStatus')->middleware('auth')->name('post');
    Route::post('/{statusId}/reply', 'StatusController@postReply')->name('reply');
    Route::get('/{statusId}/like', 'StatusController@getLike')->name('like');
});
