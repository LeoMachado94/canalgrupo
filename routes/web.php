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
    return redirect()->route('login');
});
// Admin Login/ResetPass
Auth::routes();
// Client Login/ResetPass
Route::prefix('client')->group(function() {
//Customer Password Reset routes Route::post('/password/email','Auth\CustomerForgotPasswordController@sendResetLinkEmail')->name('customer.password.email');
    Route::post('/password/reset', 'Auth\ClientResetPasswordController@reset');
    Route::get('/password/reset', 'Auth\ClientForgotPasswordController@showLinkRequestForm')->name('client.password.request');
    Route::get('/password/reset/{token}', 'Auth\ClientResetPasswordController@showResetForm')->name('client.password.reset');
    Route::post('password/email', 'Auth\ClientForgotPasswordController@sendResetLinkEmail')->name('client.password.email');
    Route::post('password/reset', 'Auth\ClientResetPasswordController@reset')->name('client.password.update');

});
// External Access
Route::get('public/clippings/{slug}', 'ExternalAccessController@clippingShow')->name('external.clippings.show');

Route::group(['middleware' => 'auth:web,client'], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    // Clippings
    Route::resource('clippings', 'ClippingsController');

    // Preview PDF
    Route::get('report/preview/{file}', 'ReportsController@show')->name('reports.show');
    // Download PDF
    Route::get('report/download/{file}', 'ReportsController@download')->name('reports.download');
    // Send Mail to Client


    // Ajax Calls
    Route::group(['prefix' => 'ajax', 'middleware' => 'cors', 'as' => 'ajax.'], function() {
        // Favorites
        Route::get('favorites', 'Ajax\FavoritesController@index')->name('favorites.index');
        Route::post('favorites/sendMail', 'Ajax\FavoritesController@sendMail')->name('favorites.send');

        // Clippings
        Route::get('clippings', 'Ajax\ClippingsController@index')->name('clippings.index');
        Route::delete('clippings/{id}', 'Ajax\ClippingsController@destroy')->name('clippings.destroy');

        // Get Graphs Data
        Route::post('report/graphsData', 'Ajax\ReportsController@getGraphsData')->name('reports.graphsData');
        // Make PDF
        Route::post('report/generate', 'Ajax\ReportsController@makePdf')->name('reports.generate');

        // Send Report Email
        Route::post('report/sendMail/{clientId}', 'Ajax\ReportsController@sendMail')->name('reports.sendMail');

        // Users
        Route::get('lists/users', 'Ajax\UsersController@lists')->name('users.lists');

        // Clients
        Route::get('clients', 'Ajax\ClientsController@index')->name('clients.index');
        Route::get('lists/clients', 'Ajax\ClientsController@lists')->name('clients.lists');
        Route::delete('clients/{id}', 'Ajax\ClientsController@destroy')->name('clients.destroy');

        // Editorials
        Route::get('editorials', 'Ajax\EditorialsController@index')->name('editorials.index');
        Route::get('lists/editorials', 'Ajax\EditorialsController@lists')->name('editorials.lists');
        Route::delete('editorials/{id}', 'Ajax\EditorialsController@destroy')->name('editorials.destroy');

        // Subjects
        Route::get('subjects', 'Ajax\SubjectsController@index')->name('subjects.index');
        Route::get('lists/subjects', 'Ajax\SubjectsController@lists')->name('subjects.lists');
        Route::post('subjects/create', 'Ajax\SubjectsController@store')->name('subjects.store');
        Route::delete('subjects/{id}', 'Ajax\SubjectsController@destroy')->name('subjects.destroy');

        // Summaries
        Route::get('summaries', 'Ajax\SummariesController@index')->name('summaries.index');
        Route::delete('summaries/{id}', 'Ajax\SummariesController@destroy')->name('summaries.destroy');

        // Vehicles
        Route::get('vehicles', 'Ajax\VehiclesController@index')->name('vehicles.index');
        Route::get('lists/vehicles', 'Ajax\VehiclesController@lists')->name('vehicles.lists');
        Route::delete('vehicles/{id}', 'Ajax\VehiclesController@destroy')->name('vehicles.destroy');

        // Users
        Route::get('users', 'Ajax\UsersController@index')->name('users.index');
        Route::delete('users/{id}', 'Ajax\UsersController@destroy')->name('users.destroy');
        // States, Cities
        Route::get('lists/states', 'Ajax\StatesController@lists')->name('states.lists');
        Route::get('lists/cities/{stateId?}', 'Ajax\CitiesController@lists')->name('cities.lists'); // Get By ID (state_id)

        // Middles
        Route::get('lists/middles', 'Ajax\MiddlesController@lists')->name('middles.lists');

        // Classifications
        Route::get('lists/classifications', 'Ajax\ClassificationsController@lists')->name('classifications.lists');

        // Exhibitions
        Route::get('lists/exhibitions', 'Ajax\ExhibitionsController@lists')->name('exhibitions.lists');

        // Sources
        Route::get('lists/sources', 'Ajax\SourcesController@lists')->name('sources.lists');

        // Uploads
        Route::post('clippings/upload', 'Ajax\UploadsController@clippingFileStore')->name('clippings.uploads.store');
        Route::delete('clippings/upload/remove/{id}', 'Ajax\UploadsController@clippingFileDestroy')->name('clippings.uploads.destroy');
    });
});

// Users Access
Route::group(['middleware' => 'auth:web'], function() {
    // Favorites
    Route::resource('favorites', 'FavoritesController');

    // Clients
    Route::resource('clients', 'ClientsController');

    // Vehicles
    Route::resource('vehicles', 'VehiclesController');

    // Editorials
    Route::resource('editorials', 'EditorialsController');

    // Subjects
    Route::resource('subjects', 'SubjectsController');

    // Summaries
    Route::resource('summaries', 'SummariesController');

    // Reports
    Route::resource('reports', 'ReportsController');

    // Users
    Route::resource('users', 'UsersController');
});
