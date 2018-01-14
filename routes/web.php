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

Route::get('/', function () {
   return view('welcome');
//var_dump(Auth::check());
    //return Config::get('services.stripe.secret');
});

Route::group(['prefix'=>'subscription','middleware'=>'auth'], function (){

    Route::get('/',[
        'as'=> 'subscription',
        'uses'=>'SubscriptionController@index'
    ]);

    Route::get('/new','SubscriptionController@create');
    Route::get('/cancel','SubscriptionController@cancel');
    Route::get('/resume','SubscriptionController@resume');
    Route::get('/change','SubscriptionController@change');
    Route::post('/register','SubscriptionController@store');
    Route::post(
        'stripe/webhook',
        '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'
    );

});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
