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
/*web*/
Route::get('/', [\App\Http\Controllers\web\HomeController::class, 'index'])->name('home');
Route::get('/single/{id}', [\App\Http\Controllers\web\SingleController::class, 'index'])->name('single');
Route::get('/tour', [\App\Http\Controllers\web\TourController::class, 'index'])->name('tour');

Route::get('/login/page', function (){
    return view('web.auth.login');
})->name('loginUser');
Route::post('/login', [\App\Http\Controllers\web\auth\LoginController::class, 'login']);
Route::get('/logout', [\App\Http\Controllers\web\auth\LoginController::class, 'logout']);
/*admin*/
Route::get('/admin/login', function () {
    return view('admin.auth.login');
})->name('loginAdmin');
Route::post('/admin/login', [\App\Http\Controllers\admin\auth\LoginController::class, 'login'])->name('auth.login');
Route::middleware(['auth'])->group(function () {
    Route::group(['middleware' => 'checkAdmin:1'], function () {
        Route::get('/admin/', function () {
            return view('admin.dashboard');
        });
        Route::get('/admin/home', [\App\Http\Controllers\admin\HomeController::class, 'index'])->name('admin.home');
        Route::get('/admin/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('auth.logout');
    });
});
