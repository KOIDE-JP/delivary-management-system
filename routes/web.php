<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarrierController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\FreightRateController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TruckTypeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\LoginAuthMiddleware;
use Illuminate\Support\Facades\Route;


Route::middleware(['web', 'setLocale'])->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/make-hash/{string}', function ($string) {
    return response()->json([
        'original' => $string,
        'hash' => bcrypt($string),
    ]);
});

Route::get('/show-app-log', function () {
    $logPath = storage_path('logs/laravel.log');
    if (!file_exists($logPath)) {
        abort(404, 'Log file not found.');
    }
    return response()->file($logPath, [
        'Content-Type' => 'text/plain'
    ]);
});

Route::middleware([
    'setLocale',
    LoginAuthMiddleware::class,
])->group(function () {

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('role.list');
        // Route::get('/create', [RoleController::class, 'create'])->name('role.create');
        // Route::post('/store', [RoleController::class, 'store'])->name('role.store');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
        Route::post('/update/{id}', [RoleController::class, 'update'])->name('role.update');
        // Route::get('/delete/{id}', [RoleController::class, 'delete'])->name('role.delete');
    });

    Route::get('/notifications/latest', [AdminController::class, 'latestNotifications']);
    Route::post('/notifications/read/{id}', [AdminController::class, 'markAsRead']);
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // New Routes for Destinations, Carriers, Truck Types, and Freight Rates
    // Route::resource('destinations', DestinationController::class);
    // Route::resource('carriers', CarrierController::class);
    // Route::resource('truck-types', TruckTypeController::class);
    // Route::resource('freight-rates', FreightRateController::class);

    Route::group(['prefix' => 'destinations', 'as' => 'destinations.'], function () {
        Route::get('/',                [DestinationController::class, 'index'])  ->name('index');
        Route::get('/create',          [DestinationController::class, 'create']) ->name('create');
        Route::post('/',               [DestinationController::class, 'store'])  ->name('store');
        Route::get('/{destination}/edit',    [DestinationController::class, 'edit'])   ->name('edit');
        Route::put('/{destination}',         [DestinationController::class, 'update']) ->name('update');
        Route::delete('/{destination}',      [DestinationController::class, 'destroy'])->name('destroy');
        Route::post('/{destination}/toggle', [DestinationController::class, 'toggle']) ->name('toggle');
    });

    Route::group(['prefix' => 'carriers', 'as' => 'carriers.'], function () {
        Route::get('/',              [CarrierController::class, 'index'])  ->name('index');
        Route::get('/create',        [CarrierController::class, 'create']) ->name('create');
        Route::post('/',             [CarrierController::class, 'store'])  ->name('store');
        Route::get('/{carrier}/edit',    [CarrierController::class, 'edit'])   ->name('edit');
        Route::put('/{carrier}',         [CarrierController::class, 'update']) ->name('update');
        Route::delete('/{carrier}',      [CarrierController::class, 'destroy'])->name('destroy');
        Route::post('/{carrier}/toggle', [CarrierController::class, 'toggle']) ->name('toggle');
    });

    Route::group(['prefix' => 'truck-types', 'as' => 'truck-types.'], function () {
        Route::get('/',               [TruckTypeController::class, 'index'])  ->name('index');
        Route::get('/create',         [TruckTypeController::class, 'create']) ->name('create');
        Route::post('/',              [TruckTypeController::class, 'store'])  ->name('store');
        Route::get('/{truckType}/edit',    [TruckTypeController::class, 'edit'])   ->name('edit');
        Route::put('/{truckType}',         [TruckTypeController::class, 'update']) ->name('update');
        Route::delete('/{truckType}',      [TruckTypeController::class, 'destroy'])->name('destroy');
        Route::post('/{truckType}/toggle', [TruckTypeController::class, 'toggle']) ->name('toggle');
    });

    Route::group(['prefix' => 'freight-rates', 'as' => 'freight-rates.'], function () {
        Route::get('/',                [FreightRateController::class, 'index'])  ->name('index');
        Route::get('/create',          [FreightRateController::class, 'create']) ->name('create');
        Route::post('/',               [FreightRateController::class, 'store'])  ->name('store');
        Route::get('/{freightRate}/edit',    [FreightRateController::class, 'edit'])   ->name('edit');
        Route::put('/{freightRate}',         [FreightRateController::class, 'update']) ->name('update');
        Route::delete('/{freightRate}',      [FreightRateController::class, 'destroy'])->name('destroy');
        Route::post('/{freightRate}/toggle', [FreightRateController::class, 'toggle']) ->name('toggle');
    });


    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        // Route::resource('/', UserController::class);
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::get('delete-users', [UserController::class, 'showSoftDeleteUsers'])->name('deleteUsers');
        Route::post('restore-user/{id}', [UserController::class, 'restoreUser'])->name('restoreUser');
    });
    
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::post('store/settings', [UserController::class, 'updateUserSettings'])->name('store-settings');
        Route::get('profile/update', [UserController::class, 'userProfileUpdate'])->name('profileUpdate');
        Route::post('profile/update', [UserController::class, 'storeUserProfileUpdate'])->name('profileUpdate');
        Route::get('/settings', [UserController::class, 'userSettings'])->name('settings');
        Route::get('change-password', [UserController::class, 'changePassword'])->name('changePassword');
        Route::post('change-password', [UserController::class, 'storeChangePassword'])->name('changePassword');
    });

    Route::group(['prefix' => 'orders', 'as' => 'order.'], function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
    });

});
