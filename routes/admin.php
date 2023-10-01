
<?php

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
    Route::put('/products/{category}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{category}', [ProductController::class, 'destroy'])->name('products.destroy');



});

