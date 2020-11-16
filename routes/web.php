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



Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/', function () {
    return view('index');
});

//Admin CRUD routes
Route::resource('admin/timetracker', 'Admin\TimeController')->middleware('admin');
// Route::get('admin/timetracker', 'Admin\TimeController@index',)->middleware('admin');
// Route::get('admin/timetracker/create', 'Admin\TimeController@create')->middleware('admin');
// Route::post('admin/timetracker', 'Admin\TimeController@store')->middleware('admin');


// Report Admin Routes
Route::get('admin/reports/create', 'Admin\ReportController@create',  [ 'as' => 'admin'])->name('admin.report.create')->middleware('admin');
Route::get('admin/reports/{report}/{year}', 'Admin\ReportController@show',  [ 'as' => 'admin'])->name('admin.report.show')->middleware('admin');
Route::get('admin/reports/{report}/{year}/{month}', 'Admin\ReportController@month', [ 'as' => 'admin'])->name('admin.report.month')->middleware('admin');

Route::post('admin/reports/getReport', 'Admin\ReportController@getReport')->name('admin.getReport')->middleware('admin');
Route::get('admin/reports/{id}/{year}/download/pdf', 'Admin\ReportController@downloadPdf')->name('admin.downloadPdf.year')->middleware('admin');
Route::get('admin/reports/{id}/{year}/{month}/download/pdf', 'Admin\ReportController@downloadPdf')->name('admin.downloadPdf.month')->middleware('admin');


// Offtime Admin Routes
Route::get('admin/staff', 'Admin\OffTimeController@index')->name('admin.staff.index')->middleware('admin');
Route::get('admin/staff/{staff}', 'Admin\OffTimeController@show')->name('admin.staff.show')->middleware('admin');

Route::get('admin/staff/{staff}/create/{year}', 'Admin\OffTimeController@create')->name('admin.staff.create');
Route::post('admin/staff/{staff}/{year}', 'Admin\OffTimeController@store')->name('admin.staff.store')->middleware('admin');

Route::get('admin/staff/{staff}/{year}/edit', 'Admin\OffTimeController@edit')->name('admin.staff.edit')->middleware('admin');
Route::patch('admin/staff/{staff}/{year}', 'Admin\OffTimeController@update')->name('admin.staff.update')->middleware('admin');



//Regular User CRUD routes
Route::resource('timetracker', 'TimeController');

Route::get('reports/create', 'ReportController@create')->name('report.create');
Route::get('reports/{report}/{year}','ReportController@show')->name('report.show');
Route::get('reports/{report}/{year}/{month}', 'ReportController@month')->name('report.month');

Route::post('reports/getReport', 'ReportController@getReport')->name('getReport');
Route::get('reports/{id}/{year}/download/pdf', 'ReportController@downloadPdf')->name('downloadPdf.year');
Route::get('reports/{id}/{year}/{month}/download/pdf', 'ReportController@downloadPdf')->name('downloadPdf.month');


Route::get('reports/create', 'ReportController@create');
Route::get('reports/{user}', 'ReportController@show');



Auth::routes();



