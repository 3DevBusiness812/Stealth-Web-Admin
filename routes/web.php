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

Auth::routes();

Route::group(['prefix' => '','namespace' => 'Auth','middleware'=>['guest']], function () { 
    Route::get('/', 'LoginController@showLoginForm')->name('admin.login'); 
});

Route::group(['prefix' => 'admin/','namespace' => 'Auth','middleware'=>['guest']], function () { 
    Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
    Route::post('submitLogin', 'LoginController@login')->name('admin.submitLogin'); 
});
Route::group(['prefix' => 'admin/','middleware'=>['auth', 'prevent-back-history']], function () { 
    Route::post('changePwd', 'Auth\ResetPasswordController@changePwd')->name('admin.changePwd');
    Route::get('logout', 'Auth\LoginController@logout')->name('admin.logout');
    Route::get('premiumUsersList', 'Admin\UserController@premiumUsersList')->name('admin.premiumUsersList');
    Route::get('premiumUsersListDt', 'Admin\UserController@premiumUsersListDt')->name('admin.premiumUsersListDt');
    Route::get('normalUsersList', 'Admin\UserController@normalUsersList')->name('admin.normalUsersList');
    Route::get('normalUsersListDt', 'Admin\UserController@normalUsersListDt')->name('admin.normalUsersListDt');
    Route::post('setPremiumUsers', 'Admin\UserController@setPremiumUsers')->name('admin.setPremiumUsers');
    Route::post('setNormalUsers', 'Admin\UserController@setNormalUsers')->name('admin.setNormalUsers');
    Route::get('allUsersList', 'Admin\UserController@allUsersList')->name('admin.allUsersList');
    Route::get('allUsersListDt', 'Admin\UserController@allUsersListDt')->name('admin.allUsersListDt');

    Route::get('dashboard', 'Admin\UserController@dashboard')->name('admin.dashboard'); 
    Route::get('editNormalUser/{id?}/{page?}', 'Admin\UserController@editNormalUser')->name('admin.editNormalUser');
    Route::post('editpostNormalUser', 'Admin\UserController@editpostNormalUser')->name('admin.editpostNormalUser');

    Route::get('deleteNormalUser', 'Admin\UserController@deleteNormalUser')->name('admin.deleteNormalUser');
    Route::get('deletePremiumUser', 'Admin\UserController@deletePremiumUser')->name('admin.deletePremiumUser');
 
    Route::get('editPremiumUser/{id?}/{page?}', 'Admin\UserController@editPremiumUser')->name('admin.editPremiumUser');
    Route::post('editpostPremiumUser', 'Admin\UserController@editpostPremiumUser')->name('admin.editpostPremiumUser');
    Route::get('settings', 'Admin\UserController@settings')->name('admin.settings');
    Route::post('changeSettings', 'Admin\UserController@changeSettings')->name('admin.changeSettings');

    Route::get('list_challenges/{id}', 'Admin\ChallengeController@list_challenges')->name('admin.list_challenges');

    Route::get('list_challenges', 'Admin\ChallengeController@list_challenges')->name('admin.list_challenges');

    Route::get('list_challenges_dt', 'Admin\ChallengeController@list_challengesDt')->name('admin.list_challenges_dt');

    Route::get('challenges/{id}', 'Admin\ChallengeController@show')->name('admin.challenges');

    Route::get('challenges_edit/{id}', 'Admin\ChallengeController@challenges_edit')->name('admin.challenges_edit');

    Route::get('get_challenges_account_dt', 'Admin\ChallengeController@get_challenges_account_dt')->name('admin.get_challenges_account_dt');

    Route::get('warning_policy_violation/{id}/{id1}', 'Admin\ChallengeController@warning_policy_violation')->name('admin.warning_policy_violation');

    Route::get('delete_user_and_challenge/{id}/{id1}', 'Admin\ChallengeController@delete_user_and_challenge')->name('admin.delete_user_and_challenge');

    Route::put('update_challenges/{id}', 'Admin\ChallengeController@update_challenges')->name('admin.update_challenges');

    Route::get('create_users', 'Admin\UserController@create_users')->name('admin.create_users');

    Route::post('store_users', 'Admin\UserController@store_users')->name('admin.store_users');

    Route::get('list_category', 'Admin\CategoryController@index')->name('admin.list_category');

    Route::get('list_category_dt', 'Admin\CategoryController@list_category_dt')->name('admin.list_category_dt');

    Route::get('create_category', 'Admin\CategoryController@create_category')->name('admin.create_category');

    Route::post('store_category', 'Admin\CategoryController@store_category')->name('admin.store_category');

    Route::get('category_edit/{id}', 'Admin\CategoryController@edit_category')->name('admin.category_edit');

    Route::put('update_category/{id}', 'Admin\CategoryController@update_category')->name('admin.update_category');

    Route::get('list_videos/{id}', 'Admin\VideoController@index')->name('admin.list_videos');

    Route::get('list_videos', 'Admin\VideoController@index')->name('admin.list_videos');

    Route::get('list_videos_dt', 'Admin\VideoController@list_videos_dt')->name('admin.list_videos_dt');

    Route::post('category_view', 'Admin\VideoController@category_view')->name('admin.category_view');

    Route::get('create_video', 'Admin\VideoController@create_video')->name('admin.create_video');

    Route::post('save_video', 'Admin\VideoController@save_video')->name('admin.save_video');

    Route::post('save_video_data', 'Admin\VideoController@save_video_data')->name('admin.save_video_data');

    Route::post('delete_video_data', 'Admin\VideoController@delete_video_data')->name('admin.delete_video_data');

    Route::post('save_video_bkp', 'Admin\VideoController@save_video_bkp')->name('admin.save_video_bkp');

    Route::post('delete_video', 'Admin\VideoController@delete_video')->name('admin.delete_video');

    Route::get('video_edit/{id}', 'Admin\VideoController@edit_video')->name('admin.video_edit');

    Route::post('update_video', 'Admin\VideoController@update_video')->name('admin.update_video');

    Route::post('get_s3_url', 'Admin\VideoController@get_s3_url')->name('admin.get_s3_url');

    Route::get('delete_challenge/{id}', 'Admin\ChallengeController@delete_challenge')->name('admin.delete_challenge');

    Route::get('test_push_notification', 'Admin\ChallengeController@test_push_notification')->name('admin.test_push_notification');

});

Route::get('password_reset/{id}', 'ResetUserPasswordController@index')->name('password_reset');
Route::post('update_password', 'ResetUserPasswordController@update_password')->name('update_password');
Route::get('reset_password_result', 'ResetUserPasswordController@reset_password_success')->name('reset_password_result');