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

Route::get('/',        ['as' => 'root_path',     'uses' => 'HomeController@index']);
Route::get('/edicts',  ['as' => 'public.edicts', 'uses' => 'EdictsController@index']);
Route::get('/edicts/{edict_id}/pdfs/{id}', ['as' => 'public.edict.show',  'uses' => 'EdictsController@showPdf']);


Route::namespace('Admin')->group(function () {
    Route::prefix('admin')->group(function () {
	/* Session
	|-------------------------------------------------------------------------- */
	Auth::routes(['register' => false]);

	Route::get('/login/signOut',  ['as' => 'admin.logout',          'uses' => 'Auth\LoginController@logout']);
	Route::get('/profile/edit',   ['as' => 'admin.profile.edit',    'uses' => 'ProfileController@edit']);
	Route::put('/profile/edit',   ['as' => 'admin.profile.update',  'uses' => 'ProfileController@update']);

	Route::get('/password/edit',  ['as' => 'admin.password.edit',   'uses' => 'ProfileController@editPassword']);
	Route::post('/password/edit', ['as' => 'admin.password.update', 'uses' => 'ProfileController@updatePassword']);

	/* Dashboard
	|-------------------------------------------------------------------------- */
	Route::get('/', [ 'as' => 'admin.dashboard' , 'uses' => 'HomeController@index']);

	/* Users resources
	|-------------------------------------------------------------------------- */
	Route::get('/users',                ['as' => 'admin.users',        'uses' => 'UsersController@index']);
	Route::get('/users/search/{term}',  ['as' => 'admin.search.users', 'uses' => 'UsersController@index']);
	Route::get('/users/new',	    ['as' => 'admin.new.user',     'uses' => 'UsersController@new']);
	Route::post('/users',		    ['as' => 'admin.create.user',  'uses' => 'UsersController@create']);
	Route::get('/users/{id}',	    ['as' => 'admin.show.user',    'uses' => 'UsersController@show']);
	Route::get('/users/{id}/edit',	    ['as' => 'admin.edit.user',    'uses' => 'UsersController@edit']);
	Route::patch('/users/{id}',	    ['as' => 'admin.update.user',  'uses' => 'UsersController@update']);
	Route::delete('/users/{id}',	    ['as' => 'admin.destroy.user', 'uses' => 'UsersController@destroy']);

	/* Servants resources
	|-------------------------------------------------------------------------- */
	Route::get('/servants/page/{page}',    ['as' => 'admin.servants.page',   'uses' => 'ServantsController@index']);
	Route::get('/servants',      	       ['as' => 'admin.servants',        'uses' => 'ServantsController@index']);
	Route::get('/servants/search/{term}/page/{page}',
	    ['as' => 'admin.search.servants.page', 'uses' => 'ServantsController@index']);
	Route::get('/servants/search/{term}',  ['as' => 'admin.search.servants', 'uses' => 'ServantsController@index']);
	Route::get('/servants/{id}',           ['as' => 'admin.show.servant',    'uses' => 'ServantsController@show']);

	/* Edicts resources
	|-------------------------------------------------------------------------- */
	Route::get('/edicts/page/{page}',	['as' => 'admin.edicts.page',   'uses' => 'EdictsController@index']);
	Route::get('/edicts', 			['as' => 'admin.edicts', 	'uses' => 'EdictsController@index']);
	Route::get('/edicts/search/{term}/page/{page}',
	    ['as' => 'admin.search.edicts.page', 'uses' => 'EdictsController@index']);
	Route::get('/edicts/search/{term?}',	['as' => 'admin.search.edicts', 'uses' => 'EdictsController@index']);
	Route::get('/edicts/new', 		['as' => 'admin.new.edict',     'uses' => 'EdictsController@new']);
	Route::post('/edicts', 			['as' => 'admin.create.edict',  'uses' => 'EdictsController@create']);
	Route::get('/edicts/{id}', 		['as' => 'admin.show.edict',    'uses' => 'EdictsController@show']);
	Route::get('/edicts/{id}/edit', 	['as' => 'admin.edit.edict',    'uses' => 'EdictsController@edit']);
	Route::patch('/edicts/{id}',		['as' => 'admin.update.edict',  'uses' => 'EdictsController@update']);
	Route::delete('/edicts/{id}', 		['as' => 'admin.destroy.edict', 'uses' => 'EdictsController@destroy']);

	/* Pdfs resources
	|-------------------------------------------------------------------------- */
	Route::get('/edicts/{id}/pdfs', 	['as' => 'admin.index.pdf',     'uses' => 'PdfController@index']);
	Route::post('/edicts/{id}/pdfs', 	['as' => 'admin.create.pdf',  'uses' => 'PdfController@create']);
	Route::get('/edicts/{edict_id}/pdfs/{id}', 	['as' => 'admin.show.pdf',  'uses' => 'PdfController@show']);
	Route::delete('/edicts/pdfs/{id}', 		['as' => 'admin.destroy.pdf', 'uses' => 'PdfController@destroy']);

	/* Category resources
	|-------------------------------------------------------------------------- */
	Route::get('/unit-categories/page/{page}', ['as' => 'admin.unit_categories.page',   'uses' => 'UnitCategoriesController@index']);
	Route::get('/unit-categories',             ['as' => 'admin.unit_categories',        'uses' => 'UnitCategoriesController@index']);
	Route::get('/unit-categories/search/{term}/page/{page}',
					           ['as' => 'admin.search.unit_categories.page', 'uses' => 'UnitCategoriesController@index']);
	Route::get('/unit-categories/search/{term?}',
					           ['as' => 'admin.search.unit_categories', 'uses' => 'UnitCategoriesController@index']);
	Route::get('/unit-categories/new', 	   ['as' => 'admin.new.unit_category',      'uses' => 'UnitCategoriesController@new']);
	Route::post('/unit-categories',            ['as' => 'admin.create.unit_category',   'uses' => 'UnitCategoriesController@create']);
	Route::get('/unit-categories/{id}/edit',   ['as' => 'admin.edit.unit_category',     'uses' => 'UnitCategoriesController@edit']);
	Route::patch('/unit-categories/{id}',      ['as' => 'admin.update.unit_category',   'uses' => 'UnitCategoriesController@update']);
	Route::delete('/unit-categories/{id}',     ['as' => 'admin.destroy.unit_category',  'uses' => 'UnitCategoriesController@destroy']);

	/* Unit resources
	|-------------------------------------------------------------------------- */
	Route::get('/units', 			       ['as' => 'admin.units',        'uses' => 'UnitsController@index']);
	Route::get('/units/page/{page}', 	       ['as' => 'admin.units.page',   'uses' => 'UnitsController@index']);
	Route::get('/units/search/{term?}', 	       ['as' => 'admin.search.units', 'uses' => 'UnitsController@index']);
	Route::get('/units/search/{term}/page/{page}', ['as' => 'admin.search.units.page', 'uses' => 'UnitsController@index']);
	Route::get('/units/{id}',                      ['as' => 'admin.show.unit',    'uses' => 'UnitsController@show']);
	Route::get('/units/new',                       ['as' => 'admin.new.unit',     'uses' => 'UnitsController@new']);
	Route::post('/units',                          ['as' => 'admin.create.unit',  'uses' => 'UnitsController@create']);
	Route::get('/units/{id}/edit',                 ['as' => 'admin.edit.unit',    'uses' => 'UnitsController@edit']);
	Route::patch('/units/{id}',                    ['as' => 'admin.update.unit',  'uses' => 'UnitsController@update']);
	Route::delete('/units/{id}',                   ['as' => 'admin.destroy.unit', 'uses' => 'UnitsController@destroy']);
    });
});

/*----------SERVANT AREA----------	*/
Route::namespace('Servant')->group(function () {
    Route::prefix('servant')->name('servant.')->group(function () {
	/* Session
	|-------------------------------------------------------------------------- */
	Route::namespace('Auth')->group(function(){
	    Route::get('/login','LoginController@showLoginForm')->name('login');
	    Route::post('/login','LoginController@login');
	    Route::get('/login/signOut',  ['as' => 'logout','uses' => 'LoginController@logout']);

	    Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	    Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');

	    Route::get('/password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
	    Route::post('/password/reset','ResetPasswordController@reset')->name('password.update');
	});

	/* Dashboard
	|----------------------------------------------------------------------------*/
	Route::get('/', [ 'as' => 'dashboard' , 'uses' => 'HomeController@index']);

	Route::get('/profile/edit',   ['as' => 'profile.edit',    'uses' => 'ProfileController@edit']);
	Route::put('/profile/edit',   ['as' => 'profile.update',  'uses' => 'ProfileController@update']);

	Route::get('/password/edit',  ['as' => 'password.edit',   'uses' => 'ProfileController@editPassword']);
	Route::post('/password/edit', ['as' => 'profile.password.update', 'uses' => 'ProfileController@updatePassword']);


	/* Edicts Inscriptions
        |----------------------------------------------------------------------------*/
	Route::get('/edicts/{edict_id}/inscriptions/new', ['as' => 'new.inscription',   'uses' => 'InscriptionsController@new']);
    Route::post('/edicts/{edict_id}/inscriptions',    ['as' => 'create.inscription','uses' => 'InscriptionsController@create']);
 	
	
	/* Edicts
	|----------------------------------------------------------------------------*/
	Route::get('/edicts/open/page/{page}', ['as' => 'edicts.page', 'uses' => 'EdictsController@indexOpen']);
	Route::get('/edicts/open/search/{term}/page/{page}', ['as' => 'search.edicts.page', 'uses' => 'EdictsController@indexOpen']);
	Route::get('/edicts/open/search/{term?}', ['as' => 'search.edicts', 'uses' => 'EdictsController@indexOpen']);
	Route::get('/edicts/open', ['as' => 'edicts', 'uses' => 'EdictsController@indexOpen']);
	Route::get('/edicts/close/page/{page}', ['as' => 'edicts.close.page', 'uses' => 'EdictsController@indexClose']);
	Route::get('/edicts/close/search/{term}/page/{page}', ['as' => 'search.edicts.close.page', 'uses' => 'EdictsController@indexclose']);
	Route::get('/edicts/close/search/{term?}', ['as' => 'search.edicts.close', 'uses' => 'EdictsController@indexClose']);
	Route::get('/edicts/close', ['as' => 'edicts.close', 'uses' => 'EdictsController@indexClose']);
    Route::get('/edicts/{id}', ['as' => 'show.edict', 'uses' => 'EdictsController@show']);

    });
});

