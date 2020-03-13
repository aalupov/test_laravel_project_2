<?php

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | contains the "web" middleware group. Now create something great!
 * |
 */
$groupData = [
    'prefix' => ''
];

// route to home page
Route::group($groupData, function () {
    $methods = [
        'index'
    ];
    Route::resource('/', 'HomePageController')->only($methods)->names('home');
});

// route to orders page
Route::group($groupData, function () {
    $methods = [
        'index',
        'edit',
        'update'
    ];
    Route::resource('/orders', 'OrdersController')->only($methods)->names('orders');
});

// route to products page
Route::group($groupData, function () {
    $methods = [
        'index'
    ];
    Route::resource('/products', 'ProductsController')->only($methods)->names('products');
});

// update the product price
Route::post('/updatePrice', 'ProductsController@updatePrice');

// route to overdue orders page
Route::get('/overdueOrders', 'OrdersController@overdueOrders')->name('overdueOrders');

// route to current orders page
Route::get('/currentOrders', 'OrdersController@currentOrders')->name('currentOrders');

// route to new orders page
Route::get('/newOrders', 'OrdersController@newOrders')->name('newOrders');

// route to completed orders page
Route::get('/completedOrders', 'OrdersController@completedOrders')->name('completedOrders');