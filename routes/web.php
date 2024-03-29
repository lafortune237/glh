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

Route::get('admin/hostels/{option}','Admin\AdminController@showHostels')->name('admin.hostels');
Route::get('admin/hostels/show/{hostel}','Admin\AdminController@showHostel')->name('admin.hostels.show');
Route::post('admin/hostels/{hostel}/validate','Admin\AdminController@validateHostel')->name('admin.hostels.validate');
Route::post('admin/hostels/{hostel}/unvalidate','Admin\AdminController@unvalidateHostel')->name('admin.hostels.unvalidate');
Route::post('admin/hostels/{hostel}/forward','Admin\AdminController@forwardHostel')->name('admin.hostels.forward');
Route::post('admin/hostels/{hostel}/unforward','Admin\AdminController@unforwardHostel')->name('admin.hostels.unforward');
Route::get('admin/hostels/show/{hostel}/rooms/{room}','Admin\AdminController@showHostelRoom')->name('admin.hostels.rooms.show');

Route::get('hostels','Hostel\HostelController@index')->name('hostels');
Route::get('hostels/new','Hostel\HostelController@create')->name('hostels.create');
Route::get('hostels/new/{hostel}/images','Hostel\HostelController@createImages')->name('hostels.create.images');
Route::post('hostels/new','Hostel\HostelController@store');
Route::post('hostels/new/{hostel}/images','Hostel\HostelController@storeImages');
Route::get('hostels/{hostel}','Hostel\HostelController@show')->name('hostels.show');
Route::get('hostels/{hostel}/edit','Hostel\HostelController@edit')->name('hostels.edit');
Route::post('hostels/{hostel}/edit','Hostel\HostelController@update');

Route::get('hostels/{hostel}/rooms','Hostel\HostelRoomController@index')->name('hostels.rooms');
Route::get('hostels/{hostel}/rooms/new','Hostel\HostelRoomController@create')->name('hostels.rooms.create');
Route::get('hostels/{hostel}/rooms/{room}/images','Hostel\HostelRoomController@createImages')->name('hostels.rooms.create.images');
Route::post('hostels/{hostel}/rooms/{room}/images','Hostel\HostelRoomController@storeImages');

Route::post('hostels/{hostel}/rooms/{room}/activate','Hostel\HostelRoomController@activateRoom')->name('hostels.rooms.activate');
Route::post('hostels/{hostel}/rooms/{room}/deactivate','Hostel\HostelRoomController@deactivateRoom')->name('hostels.rooms.deactivate');

Route::post('hostels/{hostel}/rooms/new','Hostel\HostelRoomController@store');
Route::get('hostels/{hostel}/rooms/{room}','Hostel\HostelRoomController@show')->name('hostels.rooms.show');
Route::get('hostels/{hostel}/rooms/{room}/edit','Hostel\HostelRoomController@edit')->name('hostels.rooms.edit');
Route::post('hostels/{hostel}/rooms/{room}/edit','Hostel\HostelRoomController@update');
Route::get('hostels/{hostel}/rooms/{room}/booking','Hostel\HostelRoomController@booking')->name('hostels.rooms.booking');
Route::post('hostels/{hostel}/rooms/{room}/booking','Hostel\HostelRoomController@book');

Route::get('selections/{selection}/booking','Selection\SelectionRoomController@booking')->name('selections.booking');
Route::post('selections/{selection}/booking','Selection\SelectionRoomController@book');


