<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin/login','AdminController@getLogin');
Route::get('admin/index', 'AdminController@getIndex');

Route::get('admin/dashboard', 'AdminController@getDashboard');
Route::post('admin/dashboard','AdminController@postDashboard');
Route::get('admin/logout','AdminController@getLogout');

////loai khoa hoc
//Route::get('admin/loaikhoahoc/danhsach','LoaiKhoaHocController@getDanhSach');
//Route::get('admin/loaikhoahoc/them','LoaiKhoaHocController@getThem');
//
//Route::get('deactive/{id}','LoaiKhoaHocController@getDeactive');
//Route::get('active/{id}','LoaiKhoaHocController@getActive');
//
//Route::post('admin/loaikhoahoc/luu','LoaiKhoaHocController@postLuu');

Route::group(['prefix'=>'admin'],function () {
    Route::group(['prefix' => 'loaikhoahoc'], function () {
        // admin/loaikhoahoc/danhsach
        Route::get('danhsach','LoaiKhoaHocController@getDanhSach');
        Route::get('them','LoaiKhoaHocController@getThem');
        Route::post('luu','LoaiKhoaHocController@postLuu');

        Route::get('deactive/{id}','LoaiKhoaHocController@getDeactive');
        Route::get('active/{id}','LoaiKhoaHocController@getActive');

        Route::get('sua/{id}','LoaiKhoaHocController@getSua');
        Route::post('sua/{id}','LoaiKhoaHocController@postSua');
        Route::get('xoa/{id}','LoaiKhoaHocController@getXoa');


    });

    Route::group(['prefix' => 'khoahoc'], function () {
        // admin/khoahoc/danhsach
        Route::get('danhsach','KhoaHocController@getDanhSach');
        Route::get('them','KhoaHocController@getThem');
        Route::post('luu','KhoaHocController@postLuu');

        Route::get('deactive/{id}','KhoaHocController@getDeactive');
        Route::get('active/{id}','KhoaHocController@getActive');

        Route::get('sua/{id}','KhoaHocController@getSua');
        Route::post('sua/{id}','KhoaHocController@postSua');
        Route::get('xoa/{id}','KhoaHocController@getXoa');


    });
});



