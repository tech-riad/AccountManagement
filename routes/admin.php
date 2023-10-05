
<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/getTransactionTypes/{categoryId}', [AccountsController::class, 'getTransactionTypes'])->name('admin.getTransactionTypes');


Route::prefix('admin')->group(function () {

    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

// employee

    Route::get('/employees', [EmployeeController::class, 'index'])->name('admin.employees');
    Route::post('/employees/store', [EmployeeController::class, 'store'])->name('admin.employees.store');
    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

// Bank

    Route::get('/bank', [BankController::class, 'index'])->name('admin.bank');
    Route::post('/bank/store', [BankController::class, 'store'])->name('admin.bank.store');
    Route::put('/bank/{bank}', [BankController::class, 'update'])->name('bank.update');
    Route::delete('/bank/{bank}', [BankController::class, 'destroy'])->name('bank.destroy');


// Account

    Route::get('/accounts', [AccountsController::class, 'index'])->name('admin.accounts');
    Route::post('/accounts/store', [AccountsController::class, 'store'])->name('admin.accounts.store');
    Route::put('/accounts/{account}', [AccountsController::class, 'update'])->name('accounts.update');
    Route::delete('/accounts/{account}', [AccountsController::class, 'destroy'])->name('accounts.destroy');



});

