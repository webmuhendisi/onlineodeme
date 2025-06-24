<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InvoiceController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('students', StudentController::class);

Route::get('students/{student}/debts', [DebtController::class, 'index'])->name('students.debts');
Route::get('students/{student}/debts/create', [DebtController::class, 'create'])->name('students.debts.create');
Route::post('students/{student}/debts', [DebtController::class, 'store'])->name('students.debts.store');
Route::delete('debts/{debt}', [DebtController::class, 'destroy'])->name('debts.destroy');
Route::post('debts/{debt}/pay', [PaymentController::class, 'store'])->name('debts.pay');

Route::get('invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('students', StudentController::class);
    Route::get('students/{student}/debts', [DebtController::class, 'index'])->name('students.debts');
    Route::get('students/{student}/debts/create', [DebtController::class, 'create'])->name('students.debts.create');
    Route::post('students/{student}/debts', [DebtController::class, 'store'])->name('students.debts.store');
    Route::delete('debts/{debt}', [DebtController::class, 'destroy'])->name('debts.destroy');
});
