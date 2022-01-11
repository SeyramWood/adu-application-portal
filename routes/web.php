<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/config', function () {
  Artisan::call('config:clear');
  Artisan::call('cache:clear');
  Artisan::call('config:cache');
  Artisan::call('storage:link');
  return 'Done';
});


Route::get('/login', 'Auth\LoginController@index')->name('login');

Route::prefix('dashboard')->group(function () {
  Route::get('/', 'DashboardController@index')->name('dashboard');
  Route::get('/applicants', 'DashboardController@applicants')->name('applicants');
  Route::get('/reviewed-applicants', 'DashboardController@reviewedApplicants')->name('reviewed.applicants');

  Route::get('/filter-applicants/{keys}', 'ApplicantController@filter');

  Route::post('/subscribe-to-newsletter', 'DashboardController@subscribe');
  Route::get('/subscribers', 'DashboardController@subscribers')->name('subscribers');
});
