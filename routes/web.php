<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','Common\Dashboard@index');
Route::get('customers','Customers\Customers@index');
Route::get('agents','Agents\Agents@index');


//APIs

//Super Agents
Route::post('superagent/create', 'Agents\SuperAgents@create');
Route::get('superagent/destroy/{id}', 'Agents\SuperAgents@destroy');
Route::get('account/deactivate/{id}', 'Common\Settings@deactivate');
Route::get('account/activate/{id}', 'Common\Settings@activate');
Route::get('storekeepers','Agents\SuperAgents@index');
Route::get('get_superagents','Agents\SuperAgents@getSuperAgents')->name('get_superagents');

Route::get('common/load_cites/{id}', 'Common\Settings@loadCities');

//Agents
Route::post('agent/create', 'Agents\Agents@create');
Route::get('get_agents','Agents\Agents@getAgents')->name('get_agents');

//Customers
Route::get('get_customers','Customers\Customers@getCustomers')->name('get_customers');

//Products
Route::get('products','Products\Products@index');
Route::get('products/delete/{id}','Products\Products@delete');
Route::get('get_products','Products\Products@getProducts')->name('get_products');
Route::get('get_products_clerks','Products\Products@getProductsClerks')->name('get_products_clerks');
Route::post('products/create','Products\Products@create');
Route::get('products/deactivate/{id}', 'Products\Products@deactivate');
Route::get('products/activate/{id}', 'Products\Products@activate');
Route::post('products/import', 'Products\Products@import')->name('products_import');


//Clerks
Route::get('storekeeper/products','Clerks\Clerks@index');

//Stock
Route::get('product/{product_id}/stockcard', 'Clerks\Clerks@stockCard')->name('product_stock_link');
Route::get('product/stockcarddata/{product_id?}', 'Clerks\Clerks@stockCardData')->name('product_stock_data');
Route::post('product/stock/create', 'Stock\Stock@addStock')->name('create_stock_record');
Route::post('product/stock/update', 'Stock\Stock@update')->name('update_stock_record');


//Audit
Route::get('audit/storekeepers', 'Audit\Storekeepers@index');
Route::get('audit/storekeepers/data','Audit\Storekeepers@getSuperAgents')->name('get_storekeepers_data_audit');
Route::get('audit/storekeepers/stock/{user_id?}','Audit\Storekeepers@getSuperAgentsStock')->name('get_storekeepers_stock');
Route::get('audit/storekeepers/{user_id}/stock/{product_id}/audittrail','Audit\Storekeepers@getSuperAgentsStockAuditTrail')->name('get_storekeepers_stock_audittrail');
Route::get('audit/storekeepers/stock/data/{user_id?}','Audit\Storekeepers@getSuperAgentsStockData')->name('get_storekeepers_stock_data_audit');


//Permissions
Route::get('permissions', 'Common\Settings@permissions');
Route::get('permissions/edit/revoke/{id?}', 'Common\Settings@permissionsRevoke');
Route::get('permissions/edit/grant/{id?}', 'Common\Settings@permissionsGrant');
Route::get('storekeepers/permissions','Common\Settings@getSuperAgentsAndPermission')->name('get_storekeepers_data_permissions');

Auth::routes();

