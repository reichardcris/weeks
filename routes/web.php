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

Route::get('/','HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/add_section', 'HomeController@add_section');
Route::post('/add_subject', 'HomeController@add_subject');
Route::post('/add_schedule', 'HomeController@add_schedule');

Route::get('/addStudent', 'HomeController@index')->middleware('Admin');
Route::get('/addTeacher', 'HomeController@index')->middleware('Admin');
Route::get('/scheduling', 'HomeController@scheduling')->middleware('Admin');
Route::get('/enrollStudent', 'HomeController@enrollStudent')->middleware('Admin');
Route::get('/get_Student', 'HomeController@get_Student')->middleware('Admin');
Route::post('/enroll_this_student', 'HomeController@enroll_this_student');

Route::get('/view_my_classes_by_id/{id}','HomeController@view_my_classes_by_id')->middleware('Teacher');
Route::get('/view_my_classes_by_id_admin/{id}','HomeController@view_my_classes_by_id_admin')->middleware('Admin');

Route::get('/profile/{id}','HomeController@profile')->middleware('auth');
Route::get('/profile_edit/{id}','HomeController@profile_edit')->middleware('auth');

Route::get('/my_class_record/{id}','HomeController@my_class_record_by_section')->middleware('Teacher');

Route::get('/my_class_record','HomeController@my_class_record')->middleware('Teacher');


Route::get('/create_activity','HomeController@create_activity')->middleware('Teacher');
Route::post('/create_questionare','HomeController@create_questionare')->middleware('Teacher');
Route::post('/update_sub_sec','HomeController@update_sub_sec')->middleware('Admin');

Route::get('/student_exam/{id}','HomeController@student_exam');
Route::get('/my_activities','HomeController@my_activity');
Route::post('/finished_exam','HomeController@finished_exam');
Route::post('/check_password', 'HomeController@check_password');
Route::post('/update_profile', 'HomeController@update_profile');

Route::post('/delete_assign','HomeController@delete_assign')->middleware('Admin');
Route::post('/get_question','HomeController@get_question');
Route::post('/get_question_review','HomeController@get_question_review');

Route::post('/update_question','HomeController@update_question');
Route::post('/active_exam','HomeController@active_exam');
Route::post('/delete_activity','HomeController@delete_activity');
Route::get('/get_pointers/{id}','HomeController@get_pointers');

Route::get('/activities_result','HomeController@activities_result');
Route::get('/get_my_student/{id}','HomeController@get_my_student');
Route::get('/view_graph/{student_id}/{subject}','HomeController@view_graph');
Route::post('/update_percentage','HomeController@update_percentage');
Route::get('/my_grades','HomeController@my_grades');
Route::post('/drop_subect','HomeController@drop_subect');
