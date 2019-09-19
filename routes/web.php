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
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('profile','User\UserController@showProfile')->name('users.profile');
Route::get('profile/reservations','User\UserController@showReservations')->name('users.reservations');

Route::get('admin/hostels/show/{hostel}/rooms/{room}','Admin\AdminController@showHostelRoom')->name('admin.hostels.rooms.show');
Route::get('admin/hostels/{option}','Admin\AdminController@showHostels')->name('admin.hostels');
Route::get('admin/hostels/show/{hostel}','Admin\AdminController@showHostel')->name('admin.hostels.show');


Route::get('hostels','Hostel\HostelController@index')->name('hostels');
Route::get('hostels/new','Hostel\HostelController@create')->name('hostels.create');
Route::post('hostels/new','Hostel\HostelController@store');
Route::get('hostels/{hostel}','Hostel\HostelController@show')->name('hostels.show');
Route::get('hostels/{hostel}/edit','Hostel\HostelController@edit')->name('hostels.edit');
Route::post('hostels/{hostel}/edit','Hostel\HostelController@update');

Route::get('hostels/{hostel}/rooms','Hostel\HostelRoomController@index')->name('hostels.rooms');
Route::get('hostels/{hostel}/rooms/new','Hostel\HostelRoomController@create')->name('hostels.rooms.create');
Route::post('hostels/{hostel}/rooms/new','Hostel\HostelRoomController@store');
Route::get('hostels/{hostel}/rooms/{room}','Hostel\HostelRoomController@show')->name('hostels.rooms.show');
Route::get('hostels/{hostel}/rooms/{room}/edit','Hostel\HostelRoomController@edit')->name('hostels.rooms.edit');
Route::post('hostels/{hostel}/rooms/{room}/edit','Hostel\HostelRoomController@update');
Route::get('hostels/{hostel}/rooms/{room}/book','Hostel\HostelRoomController@booking')->name('hostels.rooms.book');
Route::post('hostels/{hostel}/rooms/{room}/book','Selection\SelectionRoomController@book');


