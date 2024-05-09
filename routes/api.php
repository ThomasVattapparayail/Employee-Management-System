<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LoginController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/login',[LoginController::class, 'apiLogin']);

Route::middleware('auth:sanctum')->group(function(){
    
    Route::get('/company_list',[CompanyController::class, 'companyApi']);
});


