<?php

use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;

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

Route::middleware('auth:api')->get('/user/info', function (Request $request) {
    return new UserResource($request->user());
});

Route::middleware(['auth:api'])->group(function () {
    Route::get('employee', 'API\EmployeeController@index');
    Route::post('employee', 'API\EmployeeController@store');
    Route::get('employee/{employee}', 'API\EmployeeController@show');
    Route::put('employee/{employee}', 'API\EmployeeController@update');
    Route::delete('employee/{employee}', 'API\EmployeeController@destroy');
    Route::get('employee/selector', 'API\EmployeeController@selector');
    Route::get('employee/team/selector', 'API\EmployeeController@selectorForTeam');
    Route::get('employee/status/{health}', 'API\EmployeeController@status');

    // 機械
    Route::get('category', 'API\CategoryController@index');
    Route::post('category', 'API\CategoryController@store');
    Route::get('category/{category}', 'API\CategoryController@show');
    Route::put('category/{category}', 'API\CategoryController@update');
    Route::delete('category/{category}', 'API\CategoryController@destroy');
    Route::get('category/selector', 'API\CategoryController@selector');

    // 設備
    Route::get('facility', 'API\FacilityController@index');
    Route::post('facility', 'API\FacilityController@store');
    Route::get('facility/{facility}', 'API\FacilityController@show');
    Route::put('facility/{facility}', 'API\FacilityController@update');
    Route::delete('facility/{facility}', 'API\FacilityController@destroy');
    Route::get('facility/selector', 'API\FacilityController@selector');

    // 得意先
    Route::post('customer/import', 'API\CustomerController@import');
    Route::get('customer/selector', 'API\CustomerController@selector');
    // 商品
    Route::post('item/import', 'API\ItemController@import');
    Route::get('item/selector', 'API\ItemController@selector');
    // 作業日報
    Route::get('report', 'API\ReportController@index');
    Route::post('report', 'API\ReportController@store');
    Route::get('report/{report}', 'API\ReportController@show');
    Route::put('report/{report}', 'API\ReportController@update');
    Route::delete('report/{report}', 'API\ReportController@destroy');

    // 添付ファイル
    Route::post('attachments/report_detail', 'API\AttachmentController@storeReportDetail');
    Route::post('attachments/download/{attachment}', 'API\AttachmentController@download');
    Route::delete('attachments/{attachment}', 'API\AttachmentController@destroy');
});
