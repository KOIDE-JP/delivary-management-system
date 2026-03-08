<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\FileUploadController;
use App\Http\Controllers\Frontend\FolderUploadController;




// Route::middleware(['setLocale'])->group(function () {
Route::middleware(['setLocale'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);


});