<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['verify' => true]);

Route::get('clear_cache', function () {

    \Artisan::call('optimize:clear');
    return redirect()->back()->with("success","Cache is cleared");


});

Route::group(['middleware' => ['auth','role','check_lang','verified']], function ()
{
//    Resource Route Define

    Route::resource('user', App\Http\Controllers\Admin\UserController::class);
    Route::resource('categories', App\Http\Controllers\Admin\CategoriesController::class);
    Route::resource('account', App\Http\Controllers\Admin\AccountsController::class);
    Route::resource('incomes', App\Http\Controllers\Admin\IncomesController::class);
    Route::resource('expenses', App\Http\Controllers\Admin\ExpensesController::class);
    Route::resource('transfer', App\Http\Controllers\Admin\TransferController::class);
    Route::resource('report', App\Http\Controllers\Admin\ReportController::class);


//    Single Route Define
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');
    Route::get('/profile', [App\Http\Controllers\Admin\UserController::class, 'profile'])->name('profile');
    Route::post('/profile_update', [App\Http\Controllers\Admin\UserController::class, 'profile_update'])->name('profile-update');
    Route::post('/change_password', [App\Http\Controllers\Admin\UserController::class, 'change_password'])->name('change-password');
    Route::get('/english', [App\Http\Controllers\HomeController::class, 'english'])->name('english');
    Route::get('/gujarati', [App\Http\Controllers\HomeController::class, 'gujarati'])->name('gujarati');
    Route::get('/get_user', [App\Http\Controllers\Admin\ReportController::class, 'get_user'])->name('get_user');
    Route::get('/get_category', [App\Http\Controllers\HomeController::class, 'get_category'])->name('get_category');
    Route::get('/demo_excel', [App\Http\Controllers\Admin\CategoriesController::class, 'demo_excel'])->name('demo_excel');
    Route::post('/import', [App\Http\Controllers\Admin\CategoriesController::class, 'import'])->name('import');

//    Status Route Define
    Route::get('/userStatus', [App\Http\Controllers\Admin\UserController::class, 'userStatus'])->name('userStatus');
    Route::get('/categoriesStatus', [App\Http\Controllers\Admin\CategoriesController::class, 'categoriesStatus'])->name('categoriesStatus');
    Route::get('/accountStatus', [App\Http\Controllers\Admin\AccountsController::class, 'accountStatus'])->name('accountStatus');
    Route::get('/my-table', [App\Http\Controllers\Admin\AccountsController::class, 'my_table'])->name('my-table.update-order');
    Route::get('/backup_download', [App\Http\Controllers\HomeController::class, 'backup_download'])->name('backup-download');
    Route::get('/calendar', [App\Http\Controllers\HomeController::class, 'calendar'])->name('calendar');
});
Auth::routes();



