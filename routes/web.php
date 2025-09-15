<?php

use App\Http\Controllers\Admin\AdminAccountController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminBrandController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->name('admin.')->prefix('admin/')->group(function(){
  Route::get('dashboard', AdminDashboardController::class)->name('dashboard');

  Route::get('logout', [AdminAuthController::class, 'logout'])->name('logout');

  Route::resource('accounts', AdminAccountController::class)->except(['destroy']);
  Route::delete('/accounts/{account?}', [AdminAccountController::class, 'destroy'])->name('accounts.destroy');

  Route::resource('brands', AdminBrandController::class)->except(['destroy']);
  Route::delete('/brands/{brand?}', [AdminBrandController::class, 'destroy'])->name('brands.destroy');
  Route::delete('/brands/remove-logo/{brand}', [AdminBrandController::class, 'removeLogo'])->name('brands.remove-logo');

  Route::resource('cats', AdminCategoryController::class)->except(['destroy']);
  Route::delete('/cats/{cat?}', [AdminCategoryController::class, 'destroy'])->name('cats.destroy');

  Route::resource('products', AdminProductController::class)->except(['destroy']);
  Route::delete('/products/{product?}', [AdminProductController::class, 'destroy'])->name('products.destroy');
  Route::delete('/brands/remove-image/{product}', [AdminProductController::class, 'removeImage'])->name('products.remove-image');
});

Route::middleware(['guest'])->get('/admin', [AdminAuthController::class, 'index'])->name('admin.index');
Route::post('/admin', [AdminAuthController::class, 'authenticate']);

Route::get('/', [HomeController::class, 'index'])->name('home');