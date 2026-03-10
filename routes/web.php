<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\LoginAuthMiddleware;


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
        Route::get('/view/{id}', [OrderController::class, 'view'])->name('view');
    });

});
