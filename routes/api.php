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

Route::group(['middleware' => 'jwt.verify' ], function ($router)
{

});

Route::group(['middleware' => ['cors_me'] ], function()
{

    Route::group(['middleware' => 'jwtCheck' ], function ($router)
    {
        Route::post('/users/logout', 'AuthController@logout');
        Route::post('/users/refresh', 'AuthController@refresh');
        Route::post('/users/edit_photo', 'ApiController@edit_photo');
        Route::post('/users/update', 'ApiController@update_user');
        Route::post('/users/update_password', 'ApiController@update_password');
        Route::get('/users/photo', 'ApiController@get_photo');
        Route::get('/users/assignment', 'ApiController@get_assignment');
        Route::get('/users/get_messages/{page}/{per_page}/', 'ApiController@get_messages');
        Route::post('/users/send_messages', 'ApiController@set_message');
        Route::post('/users/set_rec_message/', 'ApiController@set_rec_message');
        Route::get('/users/get_new_messages/{last_id}/', 'ApiController@get_new_messages');
        Route::get('/users/teacher_groups', 'ApiController@teacher_groups');
        Route::get('/users/group_students/', 'ApiController@group_students');
        Route::post('/users/user_read/', 'ApiController@user_read');
        Route::get('/users/get_sub_levels/', 'ApiController@get_sub_levels');
        Route::get('/users/set_sub_level/', 'ApiController@set_sub_level');
        Route::get('/users/level/', 'ApiController@get_level');

        Route::get('/users/get_notifications', 'ApiController@get_notifications');
        Route::post('/users/register_push_token', 'ApiController@register_push_token');
        Route::get('/users/get_teacher/', 'ApiController@get_teacher');

        Route::get('/users/move_to_next_week', 'ApiController@move_to_next_week');

        Route::get('/user/', 'AuthController@me');
        Route::get('/token/check', 'AuthController@checkToken');
    });


    Route::get('/users/get_reads/', 'ApiController@get_reads')->middleware('jwt.verify');
    Route::get('/users/get_about_us/', 'ApiController@get_about_us')->middleware('jwt.verify');
    Route::get('/users/get_terms_and_conditions/', 'ApiController@get_terms_and_conditions');
    Route::post('/users/support_message', 'ApiController@support_message')->middleware('jwt.verify');
    Route::post('/users/contact_us_message', 'ApiController@contact_us_message')->middleware('jwt.verify');
    Route::get('/users/get_app_guide', 'ApiController@get_app_guide')->middleware('jwt.verify');





    Route::get('/ayah/test', 'ApiController@ayah_test');
    Route::get('/country', 'ApiController@country');

    Route::post('/users/login', 'AuthController@login');

    Route::post('/teacher/register', 'AuthController@register_teacher');
    Route::post('/teacher/complete_registration', 'AuthController@complete_teacher_registration');

    Route::post('/student/register', 'AuthController@register_student');
    Route::post('/student/complete_registration', 'AuthController@complete_student_registration');
    Route::post('/users/password/forgot', 'AuthController@forgot');
    Route::post('/users/check_reset', 'AuthController@check_reset');
    Route::post('/users/reset_password', 'AuthController@reset_password');
    Route::post('/users/platform_data', 'ApiController@platform_data');
});