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
        Route::post('them','LoaiKhoaHocController@postThem');

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
        Route::post('them','KhoaHocController@postThem');

        Route::get('deactive/{id}','KhoaHocController@getDeactive');
        Route::get('active/{id}','KhoaHocController@getActive');

        Route::get('sua/{id}','KhoaHocController@getSua');
        Route::post('sua/{id}','KhoaHocController@postSua');
        Route::get('xoa/{id}','KhoaHocController@getXoa');
    });

    Route::group(['prefix' => 'baihoc'], function () {
        // admin/baihoc/danhsach
        Route::get('danhsach','BaiHocController@getDanhSach');
        Route::get('them','BaiHocController@getThem');
        Route::post('them','BaiHocController@postThem');

        Route::get('deactive/{id}','BaiHocController@getDeactive');
        Route::get('active/{id}','BaiHocController@getActive');

        Route::get('sua/{id}','BaiHocController@getSua');
        Route::post('sua/{id}','BaiHocController@postSua');
        Route::get('xoa/{id}','BaiHocController@getXoa');
    });
    Route::group(['prefix' => 'user'], function () {
        // admin/baihoc/danhsach
        Route::get('danhsach','UserController@getDanhSach');
        Route::get('them','UserController@getThem');
        Route::post('them','UserController@postThem');

        Route::get('deactive/{id}','UserController@getDeactive');
        Route::get('active/{id}','UserController@getActive');

        Route::get('sua/{id}','UserController@getSua');
        Route::post('sua/{id}','UserController@postSua');
        Route::get('xoa/{id}','UserController@getXoa');
    });

    Route::get('ajax/loaikhoahoc/{idLoai}','AjaxController@getKhoaHoc');


});



