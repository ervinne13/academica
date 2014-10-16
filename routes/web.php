<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | This file is where you may define all of the routes that are handled
  | by your application. Just tell Laravel the URIs it should respond
  | to using a Closure or controller method. Build something great!
  |
 */

Route::get('/', 'HomeController@index');

Route::auth();
Route::get('/logout', 'Auth\LoginController@logout');

Route::group(['middleware' => 'auth'], function () {

    Route::post('files/upload', 'FilesController@upload');

    Route::resource('grading-years', 'GradingYearsController');

    Route::get('teachers/datatable', 'TeachersController@datatable');
    Route::resource('teachers', 'TeachersController');
    Route::get('teacher/{$teacherId}/classes/datatable', 'TeacherClassesController@datatable');
    Route::resource('teacher.classes', 'TeacherClassesController');

    Route::get('sections/datatable', 'SectionsController@datatable');
    Route::resource('sections', 'SectionsController');

    Route::get('students/datatable', 'StudentsController@datatable');
    Route::resource('students', 'StudentsController');

    Route::get('subjects/datatable', 'SubjectsController@datatable');
    Route::resource('subjects', 'SubjectsController');
});

