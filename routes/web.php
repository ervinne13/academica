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

Route::get('/test/pdf', 'TestController@pdf');

Route::group(['middleware' => 'auth'], function () {

    Route::post('files/upload', 'FilesController@upload');

    Route::get('grading-years/datatable', 'GradingYearsController@datatable');
    Route::resource('grading-years', 'GradingYearsController');

    Route::resource('enrollment', 'EnrollmentController');

    Route::get('period/{periodId}/class/{subjectId}/class-record/generate', 'ClassRecordsController@generate');
    Route::get('period/{periodId}/class/{subjectId}/class-record', 'ClassRecordsController@classRecord');
    Route::resource('class-records', 'ClassRecordsController');
    Route::resource('class-records', 'ClassRecordsController');

    Route::get('teachers/datatable', 'TeachersController@datatable');
    Route::get('teacher/{teacherId}/classes/datatable', 'TeacherClassesController@datatable');
    Route::get('teacher/{teacherId}/students/datatable', 'TeacherStudentsController@datatable');
    Route::resource('teachers', 'TeachersController');
    Route::resource('teacher.classes', 'TeacherClassesController');
    Route::resource('teacher.students', 'TeacherStudentsController');

    Route::get('users/datatable', 'UsersController@datatable');
    Route::get('users/{userId}/change-password', 'UsersController@changePassword');
    Route::post('users/{userId}/update-password', 'UsersController@updatePassword');
    Route::get('users/{userId}/activate', 'UsersController@activate');
    Route::get('users/{userId}/deactivate', 'UsersController@deactivate');
    Route::resource('users', 'UsersController');

    Route::get('sections/datatable', 'SectionsController@datatable');
    Route::resource('sections', 'SectionsController');

    Route::get('students/datatable', 'StudentsController@datatable');
    Route::get('students/{studentId}/print', 'StudentsController@printCard');
    Route::resource('students', 'StudentsController');

    Route::get('subjects/datatable', 'SubjectsController@datatable');
    Route::resource('subjects', 'SubjectsController');

    Route::get('classes/datatable', 'ClassesController@datatable');
    Route::get('classes/{classId}/grading/{gradedItemId}', 'ClassGradingController@create');
    Route::get('classes/{classId}/students/{gradedItemId}/grades', 'ClassGradingController@students');
    Route::post('class-grading', 'ClassGradingController@store');
    Route::resource('classes', 'ClassesController');

    // <editor-fold defaultstate="collapsed" desc="Graded Items">

    Route::get('graded-items/type/{gradedItemTypeName}', 'GradedItemsController@typeIndex');
    Route::get('graded-items/type/{gradedItemTypeName}/datatable', 'GradedItemsController@datatable');
    Route::get('graded-items/datatable', 'GradedItemsController@datatable');
    Route::resource('graded-items', 'GradedItemsController');

    // </editor-fold>
});
