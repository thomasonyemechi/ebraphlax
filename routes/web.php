<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CapitalController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CostAnalysisController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\JuteController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', function () {
    return redirect('/login');
});


// Route::get('/dashboard', function () {
//     return view('layouts.app') ;
// });


Route::get('/search', [StockController::class, 'searchItem']);
Route::get('/faker_user', [TestController::class, 'fakerExport']);
Route::get('/sendd', [Controller::class, 'seeeeend']);
Route::get('/getcredit/{id}', function ($id) {
    return supplierCredit($id);
} );



Route::group((['prefix' => 'control/', 'as' => 'control.', 'middleware' => ['auth']]), function() {


    Route::get('/dashboard', [Controller::class, 'dashboardIndex']);
    Route::post('/add_capital', [CapitalController::class, 'addCapital']);
    Route::get('/delete_capital/{capital_id}', [CapitalController::class, 'removeCapital']);



    Route::get('/pos', [StockController::class, 'posIndex']);
    Route::post('/import_stock', [StockController::class, 'restockProduct']);
    Route::post('/make_export', [CostAnalysisController::class, 'makeSales']);

    Route::get('/staffs', [StaffController::class, 'createStaffIndex']);
    Route::post('/add_staff', [StaffController::class, 'createStaff']);

    // Route::get('/staffs', [StaffController::class, 'staffIndex']);


    Route::get('/expense_overview', [ExpenseController::class, 'expensesIndex']);
    Route::get('/expenses', [ExpenseController::class, 'addIndex']);
    Route::post('/create-expenses-category', [ExpenseController::class, 'addExpensesCategory']);

    Route::get('/suppliers', [SupplierController::class, 'allSupplierIndex']);
    Route::get('/supplier/all', [SupplierController::class, 'supplierListIndex']);
    Route::get('/supplier/{supplier_id}', [SupplierController::class, 'supplierIndex']);
    Route::get('/suppliers/balance', [SupplierController::class, 'supplierBalanceIndex']);
    Route::get('/suppliers/account', [SupplierController::class, 'supplierAccountIndex']);
    Route::post('/add_supplier', [SupplierController::class, 'addSupplier']);
    Route::post('/edit_supplier', [SupplierController::class, 'editSupplier']);


    Route::get('/add_customer', [CustomerController::class, 'addCustomerIndex']);
    Route::post('/add_customer', [CustomerController::class, 'addCustomer']);
    Route::post('/edit_customer', [CustomerController::class, 'editCustomer']);
    Route::get('/customers', [CustomerController::class, 'customerListIndex']);
    Route::get('/customer/{customer_id}', [CustomerController::class, 'customerIndex']);
    Route::get('/customer/ledger/{customer_id}', [CustomerController::class, 'customerLedgerIndex']);
    Route::get('/supplier/ledger/{customer_id}', [CustomerController::class, 'supplierLedgerIndex']);
    Route::get('/customers/balance', [CustomerController::class, 'customerBalanceIndex']);



    Route::get('/products', [ProductController::class, 'productsIndex']);
    Route::post('/add_product', [ProductController::class, 'createProduct']);


    Route::get('/visitors', [VisitorController::class, 'visitorIndex']);
    Route::post('/add-visit', [VisitorController::class, 'addVisist']);
    Route::get('/delete-visit/{id}', [VisitorController::class, 'deleteVisit']);
    Route::post('/update-visit', [VisitorController::class, 'updateVisit']);
    Route::get('/update-timeout/{id}', [VisitorController::class, 'updateTimeOut']);

    
    Route::get('/jute-bags', [JuteController::class, 'juteIndex']);
    Route::get('/jute_ledger', [JuteController::class, 'juteledger']);
    Route::post('/add-jutebags', [JuteController::class, 'addJuteBags']);
    Route::get('/delete-bag/{id}', [JuteController::class, 'deleteBag']);


    Route::get('/stock', [CostAnalysisController::class, 'stockStock']);
    Route::post('/add_store_stock', [CostAnalysisController::class, 'addToStockeStoreKeeper']);
    Route::get('/stock/{id}', [CostAnalysisController::class, 'generalStockLedgerIndex2']);
    Route::get('/delete_store_stock/{id}', [CostAnalysisController::class, 'deleteStockeStoreKeeper']);



    Route::get('/manage-stock', [CostAnalysisController::class, 'coostanalysisIndex']);
    Route::post('/add-stocks', [CostAnalysisController::class, 'addStocks']);
    Route::post('/adjustment', [CostAnalysisController::class, 'adjustment']);
    Route::post('/enter_sumary', [CostAnalysisController::class, 'enter_sumary']);
    Route::post('/edit_stock_transaction', [CostAnalysisController::class, 'editStockTransaction']);
    Route::get('/delete_stock_act/{id}', [CostAnalysisController::class, 'deleteStockAccount']);
    Route::get('/delete-stock/{id}', [CostAnalysisController::class, 'deleteStock']);
    Route::get('/general-stock-legder/{id}', [CostAnalysisController::class, 'generalStockLedgerIndex']);


    Route::get('/manage-permission', [StaffController::class, 'managePermissionIndex']);
    Route::post('/update-permission', [StaffController::class, 'updatePermission']);


    Route::get('/today/{id}', [StaffController::class, 'todayInfo']);
    Route::get('/today-export', [StaffController::class, 'todayExport']);
    Route::get('/all-exported', [StaffController::class, 'allExportIndex']);
    Route::get('/daily_report', [ReportController::class, 'DailyReport']);
});


Route::get('/login', [AuthController::class, 'loginIndex'])->name('login');
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login')->with('success', 'You have been logged out');
});
Route::post('/user_login', [AuthController::class, 'userLogin']);


