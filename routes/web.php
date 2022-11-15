<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OverviewController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;

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
    return redirect('login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::get('/home', [HomeController::class, 'getHome'])->name('home');
    Route::post('/home/sales-data-sites', [HomeController::class, 'getAllDataSalesSite'])
        ->name('get.all.data.sales.site');
    Route::post('home/total-sales', [HomeController::class, 'getTotalSalesSite'])
        ->name('get.total.sales');

    // overview branch //
    Route::get('branch', [BranchController::class,'getBranch'])->name('branch');
    Route::post('branch/get-all-data', [BranchController::class,'getAllData'])->name('branch.get.all.data');
    Route::get('branchpdf/{id}', [BranchController::class,'getBranchpdf'])->name('branchpdf');
    Route::get('branchtodo/{id}', [BranchController::class,'getBranchtodo'])->name('branchtodo');
    Route::post('branch/approved', [BranchController::class, "approveOrCancel"])
        ->name('approve.or.cancel.branch');
    // overview proses //
    Route::get('overview', [OverviewController::class,'getOverview'])->name('overview');
    Route::post('overview/get-all-data', [OverviewController::class,'getAllData'])
        ->name('overview.get.all.data');
    Route::get('overviewpdf/{id}', [OverviewController::class,'getOverviewpdf'])->name('overviewpdf');
    Route::get('overviewtodo/{id}', [OverviewController::class,'getOverviewtodo'])->name('overviewtodo');
    Route::post('overview/approve-cancel', [OverviewController::class, 'approveOrCancel'])
        ->name('overview.approve.or.cancel');
    // history proses //
    Route::get('history', [HistoryController::class,'getHistory'])->name('history');
    Route::post('history/get-all-data', [HistoryController::class,'getAllData'])->name('history.get.all.data');
    Route::get('historytodo/{id}', [HistoryController::class,'getHistoryToDo'])->name('historytodo');
    Route::get('historypdf/{id}/{state}', [HistoryController::class,'getHistorypdf'])->name('historypdf');
    Route::post('history/close', [HistoryController::class, 'CloseDmsCase'])->name('closeDmsCase');
    // setting proses //
    Route::get('changepassword', [UserController::class,'getChangePassword'])->name('changepassword');
    Route::post('postchangepassword', [UserController::class,'postChangePassword'])->name('postchangepassword');
    Route::post('reset-password', [UserController::class,'resetPassword'])->name('reset.password');
    // setup admin proses //
    Route::get('admin', [UserController::class,'getAdmin'])->name('admin');
    Route::post('/admin/get-all-data', [UserController::class,'getAllData'])->name('admin.get.all.data');
    Route::get('adminviewtodo/{id?}', [UserController::class,'getAdmintodo'])->name('admintodo');
    Route::post('admin/saveupdate', [UserController::class,'updateAdmintodo'])->name('admintodo.update');
    Route::post('admin/delete', [UserController::class, 'deleteUser'])->name('admin.delete');

    Route::group(['prefix' => 'ref'], function() {

        Route::post('batch/product-group', [UserController::class, 'getProductGroupByPrincipal'])
            ->name('batch.product.groupp');

    });

    Route::group(['prefix' => 'report'], function() {
        Route::get('/hna', [ReportController::class, 'index'])->name('index.report');
        Route::get('/cbp', [ReportController::class, 'index'])->name('index.report');
        Route::post('/cbp', [ReportController::class, 'getAllDataCbp'])->name('get.data.cbp');
        Route::post('/hna', [ReportController::class, 'getAllDataHna'])->name('get.data.hna');
        Route::get('/cbp/export', [ReportController::class, 'exportExcelCbp'])->name('export.excel.cbp');
        Route::get('/hna/export', [ReportController::class, 'exportExcelHna'])->name('export.excel.cbp');
    });

});
