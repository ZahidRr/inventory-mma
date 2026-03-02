<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    // --- 1. DASHBOARD ---
    Route::get('/dashboard', [InventoryController::class, 'index'])->name('dashboard');

    // --- 2. INVENTORY LIST ---
    Route::get('/inventory', [InventoryController::class, 'inventoryIndex'])->name('inventory.index');
    Route::post('/inventory/router', [InventoryController::class, 'storeRouter'])->name('inventory.storeRouter');
    Route::post('/inventory/tool', [InventoryController::class, 'storeTool'])->name('inventory.storeTool');
    Route::put('/inventory/tool/{id}', [InventoryController::class, 'updateTool'])->name('inventory.updateTool');
    Route::delete('/inventory/tool/{id}', [InventoryController::class, 'destroyTool'])->name('inventory.destroyTool');

    // --- 3. INSTALLATIONS ---
    Route::get('/installations', [InventoryController::class, 'indexInstallation'])->name('install.index');
    Route::get('/installations/new', [InventoryController::class, 'createInstallation'])->name('install.create');
    Route::post('/installations/store', [InventoryController::class, 'storeInstallation'])->name('install.store');
    Route::get('/installations/{id}/edit', [InventoryController::class, 'editInstallation'])->name('install.edit');
    Route::put('/installations/{id}', [InventoryController::class, 'updateInstallation'])->name('install.update');
    Route::delete('/installations/{id}', [InventoryController::class, 'destroyInstallation'])->name('install.destroy');

    // --- 4. CLIENTS (SALES & DATABASE) ---
    Route::get('/clients', [InventoryController::class, 'indexClient'])->name('clients.index');
    Route::post('/clients', [InventoryController::class, 'storeClient'])->name('clients.store'); 
    Route::get('/clients/{id}/edit', [InventoryController::class, 'editClient'])->name('clients.edit');
    Route::put('/clients/{id}', [InventoryController::class, 'updateClient'])->name('clients.update');
    Route::delete('/clients/{id}', [InventoryController::class, 'destroyClient'])->name('clients.destroy');

    // --- 5. PROFILE ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/inventory/router/{id}', [InventoryController::class, 'updateRouter'])->name('inventory.updateRouter');

    // --- 6. REPORT ----
    Route::get('/reports', [InventoryController::class, 'indexReport'])->name('reports.index');
    Route::get('/reports/preview/{year}/{month}', [InventoryController::class, 'previewReport'])->name('reports.preview');
});

require __DIR__.'/auth.php';