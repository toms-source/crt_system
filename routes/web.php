<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OfficesController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// admin Route
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/reports', [ReportsController::class, 'adminReports'])->name('admin.reports');
    Route::get('/admin/dashboard', [InventoryController::class, 'adminDisplay'])->name('admin.index');
    Route::get('/admin/office', [OfficesController::class, 'displayOffice'])->name('admin.office');
    Route::get('/admin/register-manager-form', [OfficesController::class, 'fetchOfficeSelection'])->name('admin.registerForm');
    Route::get('/admin', [InventoryController::class, 'display'])->name('admin.inventory');
    Route::get('/manage-accounts/search', [UserController::class, 'search'])->name('search');
    Route::get('/admin/manage-accounts', [UserController::class, 'display'])->name('admin.manage-accounts');
    Route::match(['POST', 'PUT'], '/admin/users/{user}', [UserController::class, 'update'])->name('user.update');
    Route::patch('/admin/office/{office}', [OfficesController::class, 'updateOffice'])->name('department.update');
    Route::put('/admin/inventories/{id}/update', [InventoryController::class, 'update'])->name('admin.inventories.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::delete('/admin/office/{office}', [OfficesController::class, 'destroyOffice'])->name('office.destroy');
    Route::delete('/admin/inventory/{inventory}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::delete('/admin/archInventory/{inventory}', [InventoryController::class, 'destroyArch'])->name('archInventory.destroy');
    Route::post('/manager/register', [UserController::class, 'registerManager'])->name('admin.register');
    Route::post('admin/storeOffice', [OfficesController::class, 'storeOffice'])->name('admin.storeOffice');
    Route::post('/admin/recieve-form', [InventoryController::class, 'adminRecieve'])->name('admin.recieve');
    Route::post('/admin/approve-form', [InventoryController::class, 'adminApprove'])->name('admin.approve');
});

// Manager Route
Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/manager/reports', [ReportsController::class, 'managerReports'])->name('manager.reports');
    Route::get('/manager/user-register', [InventoryController::class, 'displayRegister'])->name('manager.register');
    Route::post('/approve-inventory', [InventoryController::class, 'approve'])->name('inventory.approve');
    Route::get('/manager/dashboard', [InventoryController::class, 'managerDisplay'])->name('manager.index');
    Route::post('/user/register', [UserController::class, 'registerUser'])->name('user.register');
});

// User Route
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/reports', [ReportsController::class, 'userReports'])->name('user.reports');
    Route::get('/user/dashboard', [InventoryController::class, 'displayIndexUser'])->name('user.index');;
    Route::get('/user/inventory-form', [InventoryController::class, 'view'])->name('form');
    Route::post('/user/create-inventory', [InventoryController::class, 'create'])->name('user.form');
});

Route::middleware('auth')->group(function () {
    Route::get('/inventory/print/{id}', [PdfController::class, 'print'])->name('print-pdf');
    Route::get('/inventory/print/arch/{id}', [PdfController::class, 'printArch'])->name('print-arch-pdf');
    Route::get('/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/profile', [UserController::class, 'destroyProfile'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
