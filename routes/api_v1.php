<?php


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

header('Access-Control-Allow-Origin: *');
header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );

Route::post('business-partner', 'BusinessPartnerController@post');
Route::put('business-partner', 'BusinessPartnerController@put');

Route::post('service-call', 'ServiceCallController@post');
Route::put('service-call', 'ServiceCallController@put');

Route::post('customer-equipment-card', 'CustomerEquipmentCardController@post');
Route::put('customer-equipment-card', 'CustomerEquipmentCardController@put');

Route::post('document', 'DocumentController@post');
Route::put('document', 'DocumentController@put');

Route::post('service-contract', 'ServiceContractController@post');
Route::put('service-contract', 'ServiceContractController@put');

Route::post('stock-transfer', 'StockTransferController@post');
Route::put('stock-transfer', 'StockTransferController@put');

Route::post('generic', 'GenericController@post');
Route::put('generic', 'GenericController@put');

Route::post('auth/login', 'AuthController@login');
Route::post('auth/logout', 'AuthController@logout');
Route::get('auth/session', 'AuthController@session');



