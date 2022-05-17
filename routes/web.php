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

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('clear',function (){
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
return 'All done';
});
Route::group(['middleware'=>'Lang'], function ()
{
    Route::get('/', function () {
        return redirect('login');
    });

    Route::get('/logout', function () {
        auth()->logout();
    });

    Route::group(['middleware'=>'admin'], function ()
    {
        Route::get('/control_panel', 'UserController@home')->name('dashboard');
        Route::get('/logout', 'UserController@logout')->name('logout');

        Route::get('/teachers/add_teacher', 'TeachersController@add_teacher')->name('add_teacher')->middleware('havePermission:add_teacher');
        Route::post('/teachers/create', 'TeachersController@set_teacher')->name('set_teacher')->middleware('havePermission:set_teacher');
        Route::get('/teachers', 'TeachersController@all_teachers')->name('all_teachers')->middleware('havePermission:all_teachers');
        Route::post('/teachers/find', 'TeachersController@find_teacher')->name('find_teacher')->middleware('havePermission:find_teacher');
        Route::get('/teachers/modify/{id}', 'TeachersController@modify_teacher')->name('modify_teacher')->middleware('havePermission:modify_teacher');
        Route::post('/teachers/update', 'TeachersController@update_teacher_data')->name('update_teacher_data')->middleware('havePermission:update_teacher_data');
        Route::post('/teachers/delete', 'TeachersController@delete_teacher')->name('delete_teacher')->middleware('havePermission:delete_teacher');
        Route::get('/teachers/level/{id}', 'TeachersController@change_teacher_level')->name('change_teacher_level')->middleware('havePermission:change_teacher_level');
        Route::post('/teachers/set_teacher_level', 'TeachersController@set_teacher_level')->name('set_teacher_level')->middleware('havePermission:set_teacher_level');
        Route::post('/teachers/delete_teacher_from_group', 'TeachersController@delete_teacher_from_group')->name('delete_teacher_from_group')->middleware('havePermission:delete_teacher_from_group');
        Route::post('/teachers/add_teacher_to_groups', 'TeachersController@add_teacher_to_groups')->name('add_teacher_to_groups')->middleware('havePermission:add_teacher_to_groups');

        Route::get('/teachers/notify_all_teachers', 'TeachersController@notify_all_teachers')->name('notify_all_teachers')->middleware('havePermission:notify_all_teachers');
        Route::post('teachers/set_notify_all_teachers', 'TeachersController@set_notify_all_teachers')->name('set_notify_all_teachers')->middleware('havePermission:set_notify_all_teachers');

        Route::get('/teachers/notify_teacher/{id}', 'TeachersController@notify_teacher')->name('notify_teacher')->middleware('havePermission:notify_teacher');
        Route::post('teachers/set_notify_teacher', 'TeachersController@set_notify_teacher')->name('set_notify_teacher')->middleware('havePermission:set_notify_teacher');

        Route::get('/admins/add_admin', 'AdminController@add_admin')->name('add_admin')->middleware('havePermission:add_admin');
        Route::post('/admins/create', 'AdminController@set_admin')->name('set_admin')->middleware('havePermission:set_admin');
        Route::get('/admins', 'AdminController@all_admins')->name('all_admins')->middleware('havePermission:all_admins');
        Route::post('/admins/find', 'AdminController@find_admin')->name('find_admin')->middleware('havePermission:find_admin');
        Route::get('/admins/modify/{id}', 'AdminController@modify_admin')->name('modify_admin')->middleware('havePermission:modify_admin');
        Route::post('/admins/update', 'AdminController@update_admin_data')->name('update_admin_data')->middleware('havePermission:update_admin_data');
        Route::post('/admins/delete', 'AdminController@delete_admin')->name('delete_admin')->middleware('havePermission:delete_admin');
        Route::get('/admins/modify_admin_permissions/{id}', 'AdminController@modify_admin_permissions')->name('modify_admin_permissions')->middleware('havePermission:modify_admin_permissions');
        Route::post('/admins/change_permissions', 'AdminController@change_permissions')->name('change_permissions')->middleware('havePermission:change_permissions');


        Route::get('/countries/add_country', 'CountriesController@add_country')->name('add_country')->middleware('havePermission:add_country');
        Route::post('/countries/create', 'CountriesController@set_country')->name('set_country')->middleware('havePermission:set_country');
        Route::get('/countries', 'CountriesController@all_countries')->name('all_countries')->middleware('havePermission:all_countries');
        Route::post('/countries/find', 'CountriesController@find_country')->name('find_country')->middleware('havePermission:find_country');
        Route::get('/countries/modify/{id}', 'CountriesController@modify_country')->name('modify_country')->middleware('havePermission:modify_country');
        Route::post('/countries/update', 'CountriesController@update_country_data')->name('update_country_data')->middleware('havePermission:update_country_data');
        Route::post('/countries/delete', 'CountriesController@delete_country')->name('delete_country')->middleware('havePermission:delete_country');


        Route::get('/students/add_student', 'StudentController@add_student')->name('add_student')->middleware('havePermission:add_student');
        Route::post('/students/create', 'StudentController@set_student')->name('set_student')->middleware('havePermission:set_student');
        Route::get('/students', 'StudentController@all_students')->name('all_students')->middleware('havePermission:all_students');
        Route::post('/students/find', 'StudentController@find_student')->name('find_student')->middleware('havePermission:find_student');
        Route::get('/students/modify/{id}', 'StudentController@modify_student')->name('modify_student')->middleware('havePermission:modify_student');
        Route::post('/students/update', 'StudentController@update_student_data')->name('update_student_data')->middleware('havePermission:update_student_data');
        Route::post('/students/delete', 'StudentController@delete_student')->name('delete_student')->middleware('havePermission:delete_student');
        Route::get('/students/level/{id}', 'StudentController@change_student_level')->name('change_student_level')->middleware('havePermission:change_student_level');
        Route::post('/students/set_student_level', 'StudentController@set_student_level')->name('set_student_level')->middleware('havePermission:set_student_level');
        Route::post('/students/change_student_group', 'StudentController@change_student_group')->name('change_student_group')->middleware('havePermission:change_student_group');
        Route::post('/students/delete_student_from_group', 'StudentController@delete_student_from_group')->name('delete_student_from_group')->middleware('havePermission:delete_student_from_group');
        Route::get('/students/student_assignment_log', 'StudentController@student_assignment_log')->name('student_assignment_log')->middleware('havePermission:student_assignment_log');

        Route::get('/students/notify_all_students', 'StudentController@notify_all_students')->name('notify_all_students')->middleware('havePermission:notify_all_students');
        Route::post('/students/set_notify_all_students', 'StudentController@set_notify_all_students')->name('set_notify_all_students')->middleware('havePermission:set_notify_all_students');

        Route::get('/students/notify_student/{id}', 'StudentController@notify_student')->name('notify_student')->middleware('havePermission:notify_student');
        Route::post('students/set_notify_student', 'StudentController@set_notify_student')->name('set_notify_student')->middleware('havePermission:set_notify_student');

        Route::get('/levels/add_level', 'LevelController@add_level')->name('add_level')->middleware('havePermission:add_level');
        Route::post('/levels/create', 'LevelController@set_level')->name('set_level')->middleware('havePermission:set_level');
        Route::get('/levels', 'LevelController@all_levels')->name('all_levels')->middleware('havePermission:all_levels');
        Route::post('/levels/find', 'LevelController@find_level')->name('find_level')->middleware('havePermission:find_level');
        Route::get('/levels/modify/{id}', 'LevelController@modify_level')->name('modify_level')->middleware('havePermission:modify_level');
        Route::post('/levels/update', 'LevelController@update_level_data')->name('update_level_data')->middleware('havePermission:update_level_data');
        Route::post('/levels/delete', 'LevelController@delete_level')->name('delete_level')->middleware('havePermission:delete_level');

        Route::get('/weeks/add', 'WeeksController@add_week')->name('add_week')->middleware('havePermission:add_week');
        Route::post('/weeks/set', 'WeeksController@set_week')->name('set_week')->middleware('havePermission:set_week');
        Route::get('/weeks', 'WeeksController@all_weeks')->name('all_weeks')->middleware('havePermission:all_weeks');
        Route::get('/weeks/modify/{id}', 'WeeksController@modify_week')->name('modify_week')->middleware('havePermission:modify_week');
        Route::post('/weeks/update', 'WeeksController@update_week')->name('update_week')->middleware('havePermission:update_week');
        Route::post('/weeks/delete', 'WeeksController@delete_week')->name('delete_week')->middleware('havePermission:delete_week');

        Route::get('/homework/add_homework', 'HomeworkController@add_homework')->name('add_homework')->middleware('havePermission:add_homework');
        Route::post('/homework/create', 'HomeworkController@set_homework')->name('set_homework')->middleware('havePermission:set_homework');
        Route::get('/homework', 'HomeworkController@all_homework')->name('all_homework')->middleware('havePermission:all_homework');
        Route::get('/homework/modify/{id}', 'HomeworkController@modify_homework')->name('modify_homework')->middleware('havePermission:modify_homework');
        Route::post('/homework/update', 'HomeworkController@update_homework_data')->name('update_homework_data')->middleware('havePermission:update_homework_data');
        Route::post('/homework/delete', 'HomeworkController@delete_homework')->name('delete_homework')->middleware('havePermission:delete_homework');

        Route::get('/groups/add_group', 'GroupController@add_group')->name('add_group')->middleware('havePermission:add_group');
        Route::post('/groups/create', 'GroupController@set_group')->name('set_group')->middleware('havePermission:set_group');
        Route::get('/groups', 'GroupController@all_groups')->name('all_groups')->middleware('havePermission:all_groups');
        Route::get('/groups/modify/{id}', 'GroupController@modify_group')->name('modify_group')->middleware('havePermission:modify_group');
        Route::post('/groups/update', 'GroupController@update_groups_data')->name('update_groups_data')->middleware('havePermission:update_groups_data');
        Route::post('/groups/delete', 'GroupController@delete_group')->name('delete_group')->middleware('havePermission:delete_group');
        Route::post('/get_group_weeks', 'GroupController@get_group_weeks')->name('get_group_weeks')->middleware('havePermission:get_group_weeks');

        Route::get('/sub_group/add_group', 'SubGroupController@add_sub_group')->name('add_sub_group')->middleware('havePermission:add_sub_group');
        Route::post('/sub_group/create', 'SubGroupController@set_sub_group')->name('set_sub_group')->middleware('havePermission:set_sub_group');
        Route::get('/sub_groups', 'SubGroupController@all_sub_groups')->name('all_sub_groups')->middleware('havePermission:all_sub_groups');
        Route::get('/sub_groups/modify/{id}', 'SubGroupController@modify_sub_group')->name('modify_sub_group')->middleware('havePermission:modify_sub_group');
        Route::post('/sub_groups/update', 'SubGroupController@update_sub_groups_data')->name('update_sub_groups_data')->middleware('havePermission:update_sub_groups_data');
        Route::post('/sub_groups/delete', 'SubGroupController@delete_sub_group')->name('delete_sub_group')->middleware('havePermission:delete_sub_group');
        Route::post('/sub_group/change_teacher', 'SubGroupController@change_group_teacher')->name('change_group_teacher')->middleware('havePermission:change_group_teacher');
        Route::post('/sub_group/add_group_students', 'SubGroupController@add_group_students')->name('add_group_students')->middleware('havePermission:add_group_students');
        Route::post('/sub_groups/ban', 'SubGroupController@ban_group')->name('ban_group')->middleware('havePermission:all_sub_groups');
        Route::post('/sub_groups/activate', 'SubGroupController@activate_group')->name('activate_group')->middleware('havePermission:modify_sub_group');

        Route::get('/send_notification', 'AdminController@send_notification')->name('send_notification')->middleware('havePermission:send_notification');
        Route::post('/set_send_notification', 'AdminController@set_send_notification')->name('set_send_notification')->middleware('havePermission:set_send_notification');

        Route::get('/send_notification', 'AdminController@send_notification')->name('send_notification')->middleware('havePermission:send_notification');
        Route::post('/set_send_notification', 'AdminController@set_send_notification')->name('set_send_notification')->middleware('havePermission:set_send_notification');

        Route::get('/settings/ayat_test', 'SettingsController@ayat_test')->name('ayat_test')->middleware('havePermission:ayat_test');
        Route::post('/settings/set_ayat_test', 'SettingsController@set_ayat_test')->name('set_ayat_test')->middleware('havePermission:set_ayat_test');
        Route::post('/settings/delete_ayat_test', 'SettingsController@delete_ayat_test')->name('delete_ayat_test')->middleware('havePermission:delete_ayat_test');
        Route::get('/settings/modify/ayah/{id}', 'SettingsController@modify_ayah')->name('modify_ayah')->middleware('havePermission:modify_ayah');
        Route::post('/settings/modify/ayah_update/', 'SettingsController@set_ayat_update')->name('set_ayat_update')->middleware('havePermission:set_ayat_update');

        Route::get('/settings/app_guide', 'SettingsController@app_guide')->name('app_guide')->middleware('havePermission:app_guide');
        Route::post('/settings/set_app_guide', 'SettingsController@set_app_guide')->name('set_app_guide')->middleware('havePermission:set_app_guide');
        Route::post('/settings/delete_app_guid', 'SettingsController@delete_app_guid')->name('delete_app_guid')->middleware('havePermission:delete_app_guid');
        Route::get('/settings/modify/app_guide/{id}', 'SettingsController@modify_app_guid')->name('modify_app_guid')->middleware('havePermission:modify_app_guid');
        Route::post('/settings/modify/update_app_guide/', 'SettingsController@update_app_guide')->name('update_app_guide')->middleware('havePermission:update_app_guide');
        Route::post('/settings/set_app_guide_video', 'SettingsController@set_app_guide_video')->name('set_app_guide_video')->middleware('havePermission:set_app_guide');
        Route::post('/settings/update_app_guide_video', 'SettingsController@update_app_guide_video')->name('update_app_guide_video')->middleware('havePermission:set_app_guide');

        Route::get('/settings/main_video', 'SettingsController@main_video')->name('main_video')->middleware('havePermission:main_video');
        Route::post('/settings/set_main_video', 'SettingsController@set_main_video')->name('set_main_video')->middleware('havePermission:set_main_video');


        Route::get('/settings/about_us', 'SettingsController@about_us')->name('about_us')->middleware('havePermission:about_us');
        Route::post('/settings/set_about_us', 'SettingsController@set_about_us')->name('set_about_us')->middleware('havePermission:set_about_us');
        Route::post('/settings/set_about_us_update', 'SettingsController@set_about_us_update')->name('set_about_us_update')->middleware('havePermission:set_about_us_update');

        Route::get('/settings/terms_conditions', 'SettingsController@terms_conditions')->name('terms_conditions')->middleware('havePermission:terms_conditions');
        Route::post('/settings/set_terms_conditions', 'SettingsController@set_terms_conditions')->name('set_terms_conditions')->middleware('havePermission:set_terms_conditions');
        Route::post('/settings/update_terms_conditions', 'SettingsController@update_terms_conditions')->name('update_terms_conditions')->middleware('havePermission:update_terms_conditions');

        Route::get('/settings/contact_us', 'SettingsController@contact_us')->name('contact_us')->middleware('havePermission:contact_us');
        Route::post('/settings/delete_contact_us', 'SettingsController@delete_contact_us')->name('delete_contact_us')->middleware('havePermission:delete_contact_us');

        Route::get('/settings/support', 'SettingsController@support')->name('support')->middleware('havePermission:support');
        Route::post('/settings/delete_support', 'SettingsController@delete_support')->name('delete_support')->middleware('havePermission:delete_support');

        Route::get('/settings/app_login_logs', 'SettingsController@app_login_logs')->name('app_login_logs')->middleware('havePermission:app_login_logs');

    });


    // Guest routs
    Route::group(['middleware' => ['guest']], function ()
    {
        // Password Reset Routes...
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset.token');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset');

        Route::post('/register', 'UserController@register')->name('register');
        Route::post('/login', 'UserController@UserLogin')->name('user.login');
        Route::get('/login', 'UserController@login')->name('login');
        Route::post('/admin_login', 'UserController@AdminLogin')->name('ad.login');
    });


    Route::get('start', 'UserController@start')->name('start');
    Route::post('set_start', 'UserController@set_start')->name('set_start');
    Route::get('language/{lang}', 'UserController@changeLang')->name('language');

});
