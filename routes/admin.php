<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'admin/me', 'middleware' => []], function () {
    Route::get('/', 'AdminController@index')->name('admin.get.index');
    Route::get('/members', 'AdminController@index')->name('admin.get.index.members');
    Route::get('/organizations', 'AdminController@index')->name('admin.get.index.organizations');
    Route::get('/departments', 'AdminController@index')->name('admin.get.index.departments');
    Route::get('/members-profile', 'AdminController@index')->name('admin.get.index.membersProfile');
    Route::get('/members-profile/{id}', 'AdminController@index')->name('admin.get.singleMemberProfile');
    Route::get('/sitesetting', 'AdminController@index')->name('admin.get.sitesetting');
    Route::get('/dictionary', 'AdminController@index')->name('admin.get.dictionary');
    Route::get('/contactinfo', 'AdminController@index')->name('admin.get.contactinfo');
    Route::get('/aboutjaol', 'AdminController@index')->name('admin.get.aboutjaol');
    Route::get('/news', 'AdminController@index')->name('admin.get.news');
    Route::get('/activity', 'AdminController@index')->name('admin.get.activity');
    Route::get('/event', 'AdminController@index')->name('admin.get.event');
    Route::get('/scholarship', 'AdminController@index')->name('admin.get.scholarship');
    Route::get('/organize-chart-ranges', 'AdminController@index')->name('admin.get.organizeChart');
    Route::get('/uploadfile', 'AdminController@index')->name('admin.get.uploadfile');
});
