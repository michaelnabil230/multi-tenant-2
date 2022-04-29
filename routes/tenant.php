<?php

use App\Http\Controllers\PostController;
use App\Http\Middleware\InitializeTenancyByDomain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware([InitializeTenancyByDomain::class])->group(function () {
    Auth::routes();
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });
    Route::resource('posts', PostController::class);
});
