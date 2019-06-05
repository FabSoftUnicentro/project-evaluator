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

Route::get('/preview-notifications', function () {
    return (new \App\Notifications\ResetPasswordNotification('teste'))->toMail('teste')->render();
});

Route::group(['middleware' => 'auth' ], function () {
    Route::namespace('Admin')->prefix('admin')->middleware('can:administer')->group(function () {
        Route::get('/', 'ProjectController@index')->name('admin.projects.index');
    });

    Route::get('/', 'ProjectController@index')->name('home');

    Route::get('/my-evaluations', 'EvaluationController@index')->name('evaluations.index');
    Route::get('/evaluate/{project}', 'EvaluationController@create')->name('evaluations.create');
    Route::post('/evaluate/{project}', 'EvaluationController@store')->name('evaluations.store');

    Route::get('/change-password', 'PasswordController@edit')->name('passwords.edit');
    Route::put('/change-password', 'PasswordController@update')->name('passwords.update');
});
