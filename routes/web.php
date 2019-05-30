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

Route::get('/', 'HomeController@index')->name('get.home.index');

Route::get('/login', 'HomeController@index')->name('get.home.login');
Route::get('/logout', 'Auth\LoginController@sessionLogout')->name('logout');
Route::get('/users-logout', 'HomeController@index')->name('get.home.users-logout');
Route::get('/jv0ABI4k2qmWQfLwSapBKfIQe7Lw0xTTVpa0xGG6', 'HomeController@index')->name('get.home.register.checker_field_inspector');
Route::get('/FWSfbih3KioEQAAOTinfTMME4HT5l8faZ9easpl7', 'HomeController@index')->name('get.home.register.institute');

Route::get('/register-successfully', 'HomeController@index')->name('get.home.register-successfully');

Route::get('/about', 'HomeController@index')->name('get.home.about');
Route::get('/contact', 'HomeController@index')->name('get.home.contact');
/**@Posts */
Route::group(['prefix' => 'posts/{type}'], function () {
    Route::get('/', 'HomeController@responsePosts')->name('get.home.posts');
    Route::get('/single/{id}', 'HomeController@responsePostsSingle')->name('get.home.posts.single');
});
/**@Posts */
Route::get('/forum', 'HomeController@index')->name('get.home.forum');
Route::get('/organization-charts', 'HomeController@index')->name('get.home.organization-charts');

/**@ResetPasswordForm */
Route::get('password/reset/{token}', 'HomeController@index')->name('password.reset');
Route::get('/reset-password-successfully', 'HomeController@index')->name('get.home.reset-password-successfully');
/**@ResetPasswordForm */

/***** @UserRoutes ***** */
Route::group(['prefix' => 'users/me', 'middleware' => []], function () {
    Route::get('/', 'UserController@index')->name('get.user.index');
    Route::get('/profile-settings', 'UserController@index')->name('get.user.profileSettings');
    Route::get('/members-profile', 'UserController@index')->name('get.user.membersProfile');
    Route::get('/members-profile/{id}', 'UserController@index')->name('get.user.singleMemberProfile');
    Route::get('/news', 'UserController@index')->name('get.user.news');
    Route::get('/activity', 'UserController@index')->name('get..user.activity');
    Route::get('/event', 'UserController@index')->name('get.user.event');
    Route::get('/scholarship', 'UserController@index')->name('get.user.scholarship');
    Route::get('/download-files', 'UserController@index')->name('get.user.downloadFile');
});
/***** @UserRoutes ***** */
/***** @FieldInspector ***** */
Route::group(['prefix' => 'field-inspector/me', 'middleware' => []], function () {
    Route::get('/', 'FieldInspector@index')->name('field-inspector.get.index');
    Route::get('/assessments', 'FieldInspector@index')->name('field-inspector.get.assessments');
});
/***** @FieldInspector ***** */







