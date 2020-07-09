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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

//Route::post('login', 'API\UserController@login');
//Route::post('register', 'API\UserController@register');
Auth::routes();
Route::post('login', 'PassportController@login');
Route::post('logout', 'PassportController@logout');


//Route::post('create', 'UserController@store');
Route::post('register', 'PassportController@store');

Route::group(['middleware' => 'auth:api'], function(){
	Route::post('details', 'API\UserController@details');
	
});


Route::group( ['middleware' => ['auth:api','api_has_permission','api_has_won_already_get']], function() {
   Route::get('posts', 'PostController@index');
   Route::get('posts/create', 'PostController@create');
   Route::post('posts/create', 'PostController@store');
   Route::get('daily_quotes', 'DailyQuotesController@index');
   Route::get('bonus_point_task', 'BonusPointTaskController@index');
   
   

});

Route::get('get_common_coins/{cwlType}', 'CommonController@getCommonCoins');

Route::group( ['middleware' => ['auth:api','api_has_permission','api_has_source_type','api_has_won_already_post']], function() {
   Route::post('user_coins_store', 'UserCoinsController@store');
   
});

Route::group( ['middleware' => ['auth:api','api_has_permission',]], function() {
   Route::post('get_user_coins', 'UserCoinsController@getUserCoins');
});


Route::get('get_action_types', 'CommonController@getActionTypes');

Route::get('get_spinwheel_coins', 'CommonController@getSpinWheelCoins');

//new common api 
Route::post('common_action_detail', 'CommonController@getCommonActionDetails');