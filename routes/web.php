<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'CompanyController@index')->name('index');
Route::get('/index', 'CompanyController@index')->name('index');

Route::post('/companysave', 'CompanyController@companysave');
Route::post('/companyinfo', 'CompanyController@companyinfo');
Route::post('/companydelete', 'CompanyController@companydelete');


Route::get('/person/{cid}', 'CompanyController@person')->name('person');
Route::post('/personsave', 'CompanyController@personsave');
Route::post('/personinfo', 'CompanyController@personinfo');
Route::post('/persondelete', 'CompanyController@persondelete');

Route::get('/address/{cid}', 'CompanyController@address')->name('address');
Route::post('/addresssave', 'CompanyController@addresssave');
Route::post('/addressinfo', 'CompanyController@addressinfo');
Route::post('/addressdelete', 'CompanyController@addressdelete');
