<?php /** @noinspection PhpUndefinedClassInspection */

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

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'Front\\FrontController');
    Route::get('/new', [\App\Http\Controllers\Auth\AuthController::class, 'redirectToSteam']);
    Route::get('/new/handle', [\App\Http\Controllers\Auth\AuthController::class, 'handle']);
    Route::get('/apply', 'Application\\TempApplicationController@displayApplicationCreation')->name('apply');
    Route::post('/new', 'Application\\TempApplicationController@handleApplicationCreation');
    Route::post('/billing', 'Billing\\BillingController@handlePayment');
    Route::get('/edit/{uuid}', 'Application\\TempApplicationController@displayApplicationEdit');
    Route::post('/edit', 'Application\\TempApplicationController@handleApplicationEdit');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/', 'Admin\\AdminController@displayTempApplications');
    Route::get('/admin/accepted', 'Admin\\AdminController@displayAcceptedApplications');
    Route::get('/admin/rejected', 'Admin\\AdminController@displayRejectedApplications');
    Route::get('/admin/returned', 'Admin\\AdminController@displayReturnedApplications');
	Route::get('/admin/check', 'Admin\\AdminController@usercheck');
    Route::get('/admin/{uuid}', 'Admin\\AdminController@displayTempApplicationInfo');
    Route::get('/admin/{uuid}/{action}', 'Admin\\AdminController@actOnTempApplication');
    Route::get('/adminn/{action}', 'Admin\\AdminController@actOnTempApplicationDenyReturn');
    //Route::get('/admin/campaign/new', 'Admin\\AdminController@displayCampaignAddition');
    //Route::post('/admin/campaign/new', 'Admin\\AdminController@handleCampaignAddition');

});

Route::get('/auth', 'Auth\\DiscordAuthController');
