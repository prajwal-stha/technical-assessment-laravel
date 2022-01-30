<?php

use Illuminate\Support\Facades\Route;


Route::get('/customer-details/get/', 'CustomerDetailController@getAllCustomerDetails');
Route::get('/customer-details/view/{guid}', 'CustomerDetailController@viewCustomerDetail');
Route::patch('/customer-details/update/{guid}', 'CustomerDetailController@updateCustomerDetail');
Route::delete('/education-detail/delete/{guid}', 'CustomerDetailController@deleteEducationDetails');
Route::delete('/customer-detail/delete/{guid}', 'CustomerDetailController@deleteCustomerDetails');
Route::post('/customer-detail/delete/bulk', 'CustomerDetailController@bulkDeleteCustomerDetails');
Route::post('/customer-detail/restore/bulk', 'CustomerDetailController@bulkRestoreCustomerDetails');
Route::get('/customer-detail/restore/{guid}', 'CustomerDetailController@restoreCustomerDetails');





