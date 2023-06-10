<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

Route::get('/', function () {
    return redirect()->route('customers.index');
});
// Route::get('/customers/{id}/edit', 'CustomerController@edit')->name('customers.edit');
// Route::put('/customers/{id}', 'CustomerController@update')->name('customers.update');

Route::resource('customers', CustomerController::class);
