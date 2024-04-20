<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OrderItemsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get_category', [CategoryController::class, 'get_category']);
Route::get('/delete_category/{id}', [CategoryController::class, 'delete_category']);
Route::post('/add_category', [CategoryController::class, 'add_category']);

Route::get('/get_brand', [BrandController::class, 'get_brand']);
Route::get('/delete_brand/{id}', [BrandController::class, 'delete_brand']);
Route::post('/add_brand', [BrandController::class, 'add_brand']);


Route::get('/get_product', [ProductController::class, 'get_product']);
Route::post('/add_products', [ProductController::class, 'add_products']);
Route::get('/edit_product/{id}', [ProductController::class, 'edit_product']);
Route::post('/update_product/{id}', [ProductController::class, 'update_product']);

Route::get('/delete_product/{id}', [ProductController::class, 'delete_product']);

Route::get('/get_user', [Controller::class, 'get_user']);
Route::get('/delete_user/{id}', [Controller::class, 'delete_user']);
Route::get('/edit_user/{id}', [Controller::class, 'edit_user']);
Route::post('/update_user/{id}', [Controller::class, 'update_user']);


Route::post('/add_review', [ReviewController::class, 'add_review']);

Route::post('/add_OrderItem', [OrderItemsController::class, 'add_OrderItem']);
Route::get('/get_OrderItem', [OrderItemsController::class, 'get_OrderItem']);
Route::get('/delete_OrderItem/{id}', [OrderItemsController::class, 'delete_OrderItem']);

Route::post('/add_orders', [OrderController::class, 'add_orders']);
Route::get('/get_all_Order', [OrderController::class, 'get_all_Order']);
Route::get('/delete_order_item/{id}', [OrderController::class, 'delete_order_item']);
Route::get('/getOrderItemByOrderId/{id}', [OrderController::class, 'getOrderItemByOrderId']);
Route::post('/update_order_status/{id}', [OrderController::class, 'update_order_status']);

Route::get('/get_orders', [OrderItemsController::class, 'get_orders']);
Route::get('/delete_Order/{id}', [OrderItemsController::class, 'delete_Order']);

Route::get('/get_order_details', [OrderController::class, 'get_order_details']);

Route::get('/reports', [ReportController::class, 'getReports']);