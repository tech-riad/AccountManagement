
<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->group(function () {

    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

// Product

    Route::get('/products', [ProductController::class, 'index'])->name('admin.products');
    Route::post('/products/store', [ProductController::class, 'store'])->name('admin.products.store');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

// Bank

    Route::get('/bank', [BankController::class, 'index'])->name('admin.bank');
    Route::post('/bank/store', [BankController::class, 'store'])->name('admin.bank.store');
    Route::put('/bank/{bank}', [BankController::class, 'update'])->name('bank.update');
    Route::delete('/bank/{bank}', [BankController::class, 'destroy'])->name('bank.destroy');


// Account

    Route::get('/accounts', [AccountsController::class, 'index'])->name('admin.accounts');
    Route::post('/accounts/store', [AccountsController::class, 'store'])->name('admin.accounts.store');
    Route::put('/accounts/{product}', [AccountsController::class, 'update'])->name('accounts.update');
    Route::delete('/accounts/{product}', [AccountsController::class, 'destroy'])->name('accounts.destroy');



});

