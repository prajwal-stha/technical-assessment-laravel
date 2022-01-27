<?php

use Illuminate\Support\Facades\Route;


Route::get('/customer-details/get/', 'CustomerDetailController@getAllCustomerDetails');
Route::get('/customer-details/view/{guid}', 'CustomerDetailController@viewCustomerDetail');
Route::patch('/customer-details/update/{guid}', 'CustomerDetailController@updateCustomerDetail');
Route::delete('/education-details/delete/{guid}', 'CustomerDetailController@deleteEducationDetails');
Route::delete('/customer-detail/delete', 'CustomerDetailController@deleteCustomerDetails');
Route::post('/customer-detail/restore', 'CustomerDetailController@restoreCustomerDetails');





