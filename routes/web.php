<?php

use App\Http\Controllers\Ajax\CitiesController as AjaxCitiesController;
use App\Http\Controllers\Ajax\ClassificationsController as AjaxClassificationsController;
use App\Http\Controllers\Ajax\ClientsController as AjaxClientsController;
use App\Http\Controllers\Ajax\ClippingsController as AjaxClippingsController;
use App\Http\Controllers\Ajax\EditorialsController as AjaxEditorialsController;
use App\Http\Controllers\Ajax\ExhibitionsController as AjaxExhibitionsController;
use App\Http\Controllers\Ajax\FavoritesController as AjaxFavoritesController;
use App\Http\Controllers\Ajax\MiddlesController as AjaxMiddlesController;
use App\Http\Controllers\Ajax\ReportsController as AjaxReportsController;
use App\Http\Controllers\Ajax\SourcesController as AjaxSourcesController;
use App\Http\Controllers\Ajax\StatesController as AjaxStatesController;
use App\Http\Controllers\Ajax\SubjectsController as AjaxSubjectsController;
use App\Http\Controllers\Ajax\SummariesController as AjaxSummariesController;
use App\Http\Controllers\Ajax\UploadsController as AjaxUploadsController;
use App\Http\Controllers\Ajax\UsersController as AjaxUsersController;
use App\Http\Controllers\Ajax\VehiclesController as AjaxVehiclesController;
use App\Http\Controllers\Auth\ClientForgotPasswordController;
use App\Http\Controllers\Auth\ClientResetPasswordController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ClippingsController;
use App\Http\Controllers\EditorialsController;
use App\Http\Controllers\ExternalAccessController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\SummariesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VehiclesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});
// Admin Login/ResetPass
Auth::routes();
// Client Login/ResetPass
Route::prefix('client')->group(function() {
//Customer Password Reset routes Route::post('/password/email','Auth\CustomerForgotPasswordController@sendResetLinkEmail')->name('customer.password.email');
    Route::post('/password/reset', [ClientResetPasswordController::class, 'reset']);
    Route::get('/password/reset', [ClientForgotPasswordController::class, 'showLinkRequestForm'])->name('client.password.request');
    Route::get('/password/reset/{token}', [ClientResetPasswordController::class, 'showResetForm'])->name('client.password.reset');
    Route::post('password/email', [ClientForgotPasswordController::class, 'sendResetLinkEmail'])->name('client.password.email');
    Route::post('password/reset', [ClientResetPasswordController::class, 'reset'])->name('client.password.update');

});
// External Access
Route::get('public/clippings/{slug}', [ExternalAccessController::class, 'clippingShow'])->name('external.clippings.show');

Route::group(['middleware' => 'auth:web,client'], function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Clippings
    Route::resource('clippings', ClippingsController::class);

    // Download PDF
    Route::get('report/download/{file}', [ReportsController::class, 'download'])->name('reports.download');
    // Send Mail to Client


    // Ajax Calls
    Route::group(['prefix' => 'ajax', 'middleware' => 'cors', 'as' => 'ajax.'], function() {
        // Favorites
        Route::get('favorites', [AjaxFavoritesController::class, 'index'])->name('favorites.index');
        Route::post('favorites/sendMail', [AjaxFavoritesController::class, 'sendMail'])->name('favorites.send');

        // Clippings
        Route::get('clippings', [AjaxClippingsController::class, 'index'])->name('clippings.index');
        Route::delete('clippings/{id}', [AjaxClippingsController::class, 'destroy'])->name('clippings.destroy');

        // Get Graphs Data
        Route::post('report/graphsData', [AjaxReportsController::class, 'getGraphsData'])->name('reports.graphsData');
        // Make PDF
        Route::post('report/generate', [AjaxReportsController::class, 'makePdf'])->name('reports.generate');

        // Send Report Email
        Route::post('report/sendMail/{clientId}', [AjaxReportsController::class, 'sendMail'])->name('reports.sendMail');

        // Users
        Route::get('lists/users', [AjaxUsersController::class, 'lists'])->name('users.lists');

        // Clients
        Route::get('clients', [AjaxClientsController::class, 'index'])->name('clients.index');
        Route::get('lists/clients', [AjaxClientsController::class, 'lists'])->name('clients.lists');
        Route::delete('clients/{id}', [AjaxClientsController::class, 'destroy'])->name('clients.destroy');

        // Editorials
        Route::get('editorials', [AjaxEditorialsController::class, 'index'])->name('editorials.index');
        Route::get('lists/editorials', [AjaxEditorialsController::class, 'lists'])->name('editorials.lists');
        Route::delete('editorials/{id}', [AjaxEditorialsController::class, 'destroy'])->name('editorials.destroy');

        // Subjects
        Route::get('subjects', [AjaxSubjectsController::class, 'index'])->name('subjects.index');
        Route::get('lists/subjects', [AjaxSubjectsController::class, 'lists'])->name('subjects.lists');
        Route::post('subjects/create', [AjaxSubjectsController::class, 'store'])->name('subjects.store');
        Route::delete('subjects/{id}', [AjaxSubjectsController::class, 'destroy'])->name('subjects.destroy');

        // Summaries
        Route::get('summaries', [AjaxSummariesController::class, 'index'])->name('summaries.index');
        Route::delete('summaries/{id}', [AjaxSummariesController::class, 'destroy'])->name('summaries.destroy');

        // Vehicles
        Route::get('vehicles', [AjaxVehiclesController::class, 'index'])->name('vehicles.index');
        Route::get('lists/vehicles', [AjaxVehiclesController::class, 'lists'])->name('vehicles.lists');
        Route::delete('vehicles/{id}', [AjaxVehiclesController::class, 'destroy'])->name('vehicles.destroy');

        // Users
        Route::get('users', [AjaxUsersController::class, 'index'])->name('users.index');
        Route::delete('users/{id}', [AjaxUsersController::class, 'destroy'])->name('users.destroy');
        // States, Cities
        Route::get('lists/states', [AjaxStatesController::class, 'lists'])->name('states.lists');
        Route::get('lists/cities/{stateId?}', [AjaxCitiesController::class, 'lists'])->name('cities.lists'); // Get By ID (state_id)

        // Middles
        Route::get('lists/middles', [AjaxMiddlesController::class, 'lists'])->name('middles.lists');

        // Classifications
        Route::get('lists/classifications', [AjaxClassificationsController::class, 'lists'])->name('classifications.lists');

        // Exhibitions
        Route::get('lists/exhibitions', [AjaxExhibitionsController::class, 'lists'])->name('exhibitions.lists');

        // Sources
        Route::get('lists/sources', [AjaxSourcesController::class, 'lists'])->name('sources.lists');

        // Uploads
        Route::post('clippings/upload', [AjaxUploadsController::class, 'clippingFileStore'])->name('clippings.uploads.store');
        Route::delete('clippings/upload/remove/{id}', [AjaxUploadsController::class, 'clippingFileDestroy'])->name('clippings.uploads.destroy');
    });
});

// Users Access
Route::group(['middleware' => 'auth:web'], function() {
    // Favorites
    Route::resource('favorites', FavoritesController::class);

    // Clients
    Route::resource('clients', ClientsController::class);

    // Vehicles
    Route::resource('vehicles', VehiclesController::class);

    // Editorials
    Route::resource('editorials', EditorialsController::class);

    // Subjects
    Route::resource('subjects', SubjectsController::class);

    // Summaries
    Route::resource('summaries', SummariesController::class);

    // Reports
    Route::resource('reports', ReportsController::class);

    // Users
    Route::resource('users', UsersController::class);
});

// Registered after Route::resource('reports') because both are named "reports.show" and route() must keep resolving to /reports/{report}.
Route::group(['middleware' => 'auth:web,client'], function() {
    // Preview PDF
    Route::get('report/preview/{file}', [ReportsController::class, 'show'])->name('reports.show');
});
