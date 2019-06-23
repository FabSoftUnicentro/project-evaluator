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

Auth::routes([
    'register' => false,
    'verify' => false
]);

Route::group(['middleware' => 'auth'], function () {
    Route::namespace('Admin')->prefix('admin')->middleware('can:administer')->group(function () {
        Route::get('/', 'ProjectRankingController@index')->name('admin.projects.ranking.index');
        Route::get('/projects/{project}/evaluations', 'ProjectEvaluationsController@index')->name('admin.projects.evaluations.index');

        Route::get('/projects', 'ProjectController@index')->name('admin.projects.index');
        Route::get('/projects/{project}/create', 'ProjectController@create')->name('admin.projects.create');
        Route::post('/projects', 'ProjectController@store')->name('admin.projects.store');

        Route::get('/projects/{project}/edit', 'ProjectController@edit')->name('admin.projects.edit');
        Route::put('/projects/{project}', 'ProjectController@update')->name('admin.projects.update');

        Route::get('/projects/{project}', 'ProjectController@show')->name('admin.projects.show');
        Route::delete('/projects/{project}', 'ProjectController@destroy')->name('admin.projects.destroy');
    });

    Route::get('/', 'ProjectController@index')->name('home');

    Route::get('/my-evaluations', 'EvaluationController@index')->name('evaluations.index');
    Route::get('/evaluate/{project}', 'EvaluationController@create')->name('evaluations.create');
    Route::post('/evaluate/{project}', 'EvaluationController@store')->name('evaluations.store');

    Route::get('/change-password', 'PasswordController@edit')->name('passwords.edit');
    Route::put('/change-password', 'PasswordController@update')->name('passwords.update');
});
