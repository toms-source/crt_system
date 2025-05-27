<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OfficesController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\get;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pdf-test', function() {
    return view('pdf.pdf-test');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

//Route::get('/dashboard', [InventoryController::class, 'display'])->middleware(['auth', 'role:admin'])->name('dashboard');

// admin Route
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/reports', function () {
        return view('admin.reports');
    })->name('admin.reports');
    Route::get('/inventory/print/{id}', [PdfController::class, 'print'])->name('print-pdf');
    Route::get('/admin/dashboard', [InventoryController::class, 'display'])->name('admin.index');
    Route::get('/admin/office', [OfficesController::class, 'display'])->name('admin.office');
    Route::get('/admin/register-manager-form', [OfficesController::class, 'fetchSelection'])->name('admin.registerForm');
    Route::get('/admin', [InventoryController::class, 'display'])->name('admin.inventory');
    Route::get('/manage-accounts/search', [UserController::class, 'search'])->name('search');
    Route::get('/admin/manage-accounts', [UserController::class, 'display'])->name('admin.manage-accounts');
    Route::match(['POST', 'PUT'], '/admin/users/{user}', [UserController::class, 'update'])->name('user.update');
    Route::patch('/admin/office/{office}', [OfficesController::class, 'update'])->name('department.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::delete('/admin/office/{office}', [OfficesController::class, 'destroy'])->name('office.destroy');
    Route::post('/manager/register', [RegisterController::class, 'registerManager'])->name('admin.register');
    Route::post('admin/storeOffice', [OfficesController::class, 'storeOffice'])->name('admin.storeOffice');
    Route::post('/admin/recieve-form', [InventoryController::class, 'adminRecieve'])->name('admin.recieve');
    Route::post('/admin/approve-form', [InventoryController::class, 'adminApprove'])->name('admin.approve');
});

// Manager Route
Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/manager/reports', function () {
        return view('manager.reports');
    })->name('manager.reports');

    Route::get('/user-register', function () {
        return view('manager.register');
    })->name('manager.register');

    Route::post('/approve-inventory', [InventoryController::class, 'approve'])->name('inventory.approve');
    Route::get('/manager/dashboard', [InventoryController::class, 'displayIndexManager'])->name('manager.index');
    Route::post('/user/register', [RegisterController::class, 'registerUser'])->name('user.register');
});

// User Route
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [InventoryController::class, 'displayIndexUser'])->name('user.index');;
    Route::get('/user/inventory-form', [InventoryController::class, 'view'])->name('form');
    Route::post('/user/create-inventory', [InventoryController::class, 'create'])->name('user.form');
    Route::get('/user/reports', function () {
        return view('user.reports');
    })->name('user.reports');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
