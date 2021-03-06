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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/subjects/{subjectId}/graded-items', 'GradedItemsController@getBySubject');

Route::get('/students/search', 'StudentsController@search');

Route::get('teacher/{teacherId}/classes', 'TeacherClassesController@listJSON');
Route::get('teacher/{teacherId}/classes/{levelId}', 'TeacherClassesController@levelListJSON');

Route::get('class/{classId}/students', 'ClassStudentsController@index');
Route::delete('class/{classId}/students/{studentId}', 'ClassStudentsController@destroy');

Route::post('/class/{classId}/assign', 'ClassesController@assignGradedItem');
Route::post('/class/{classId}/assign-multiple', 'ClassesController@assignGradedItems');
Route::get('/class/{classId}/graded-items', 'ClassesController@getGradedItems');

Route::get('sections/{sectionId}/class', 'SectionsController@classes');
Route::post('sections/{sectionId}/class/create', 'SectionsController@storeClass');
Route::delete('sections/{sectionId}/class/{classId}', 'SectionsController@destroyClass');
Route::delete('sections/{sectionId}/class', 'SectionsController@destroyAllClass');

Route::get('graded-items', 'GradedItemsController@get');

// For testing
Route::get('/students/{studentId}/grades', 'StudentsController@getGrades');
Route::get('/test', 'TestController@test');
