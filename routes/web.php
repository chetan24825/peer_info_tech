<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\WebsiteTypeController;

// Route::get('/', function () {
// return redirect()->route('login');

//  });
Route::get('test-route', function () {
    return "testing okay";
});

#comment
#check changes in locallally



Route::get('/dashboard', [ClientController::class, 'Dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::prefix('clients')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/history', [ClientController::class, 'history'])->name('clients.history');

    // Route::get('/plans/{id}', [ClientController::class, 'GetIndividualPlan'])->name('get.client.plan.individually');

    Route::post('/store', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/create', [ClientController::class, 'createClient'])->name('clients.create');
    Route::delete('/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
    Route::get('/{id}', [ClientController::class, 'view'])->name('clients.view');
    Route::get('/get/{id}', [ClientController::class, 'get'])->name('clients.get');
    Route::post('/update', [ClientController::class, 'update'])->name('clients.update');

    // Route::get('/expiring-list', [ClientController::class, 'expiringList'])->name('clients.expiring.list');


    Route::get('/re-new-plan', [ClientController::class, 'ReNewPlan'])->name('clients.renew.plan');
    Route::post('/re-new-plan/store', [ClientController::class, 'ReNewPlanStore'])->name('clients.renew.plan.store');

    #Excel Export Route;
    Route::get('/export', [ClientController::class, 'ClientExport'])->name('clients.export');
    Route::get('/expiring-list/export', [ClientController::class, 'ExpiringListExport'])->name('expiring.list.export');
})->middleware(['auth', 'verified']);


Route::controller(PlanController::class)->prefix('plans')->group(function () {
    Route::get('/client', 'singleClientListPlan')->name('plans.client'); //get all plan of single client;
    Route::get('/index', 'index')->name('plan.index');
    Route::get('/{id}', 'view')->name('plan.view');
    Route::post('/store-sub-plans', 'storeSubPlan')->name('store.sub.plan');
    Route::post('/upgrate-plan', 'upgratePlan')->name('upgrate.plan');
    Route::get('/test', 'test')->name('test.data');
});



Route::get('/country', [CountryController::class, 'Index'])->name('country');
Route::post('/country', [CountryController::class, 'store'])->name('country.store');
Route::put('/country', [CountryController::class, 'update'])->name('country.update');
Route::get('/country/get/{id}', [CountryController::class, 'getCountry'])->name('get.country');
Route::delete('/country/delete/{id}', [CountryController::class, 'delete'])->name('country.delete');

#Category Route;
Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/{id}', [CategoryController::class, 'getById'])->name('category.get');
Route::delete('/category', [CategoryController::class, 'delete'])->name('category.delete');
Route::patch('/category', [CategoryController::class, 'update'])->name('category.update');
Route::post('/category', [CategoryController::class, 'store'])->name('category.store');

#Website Type Route;
Route::get('/website', [WebsiteTypeController::class, 'index'])->name('website.index');
Route::get('/website/{id}', [WebsiteTypeController::class, 'getById'])->name('website.get');
Route::delete('/website/{id}', [WebsiteTypeController::class, 'delete'])->name('website.delete');
Route::patch('/website', [WebsiteTypeController::class, 'update'])->name('website.update');
Route::post('/website', [WebsiteTypeController::class, 'store'])->name('website.store');

#Platform Type Route;
Route::get('/platform', [PlatformController::class, 'index'])->name('platform.index');
Route::get('/platform/{id}', [PlatformController::class, 'getById'])->name('platform.get');
Route::delete('/platform/{id}', [PlatformController::class, 'delete'])->name('platform.delete');
Route::patch('/platform', [PlatformController::class, 'update'])->name('platform.update');
Route::post('/platform', [PlatformController::class, 'store'])->name('platform.store');


#Excel import Route
Route::get('/import', [ClientController::class, 'ImportExcelClientView'])->name('import.excel.client.view');
Route::post('/import', [ClientController::class, 'ImportExcelClientSave'])->name('import.excel.client.save');
Route::get('/excel-sample-download', [ClientController::class, 'downloadExcel'])->name('download.excel');
################################################################################################
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
