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

use Illuminate\Support\Facades\Route;

Route::get( '/', function () {
    return view( 'welcome' );
} )->name( 'home' );

Route::get( 'register', 'CustomAuth\RegisterController@showRegistrationForm' )->name( 'register' )->middleware( 'web' );
Route::post( 'register', 'CustomAuth\RegisterController@register' )->middleware( 'web' );

Route::get( 'login', 'CustomAuth\LoginController@showLoginForm' )->name( 'login' );
Route::post( 'login', 'CustomAuth\LoginController@login' );
Route::post( 'logout', 'Auth\LoginController@logout' )->name( 'logout' );

Route::get( 'password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm' )->name( 'password.request' );
Route::post( 'password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail' )->name( 'password.email' );
Route::get( 'password/reset/{token}', 'Auth\ResetPasswordController@showResetForm' )->name( 'password.reset' );
Route::post( 'password/reset', 'Auth\ResetPasswordController@reset' )->name( 'password.update' );

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

// Register Route Group
Route::group( ['as' => 'register.', 'prefix' => 'register', 'namespace' => 'Register', 'middleware' => ['auth', 'register']], function () {

    Route::get( 'dashboard', 'DashboardController@index' )->name( 'dashboard' );
    Route::resource( 'dept', 'DeptController' );
    Route::resource( 'hall', 'HallController' );
    Route::resource( 'session', 'SessionController' );
    Route::get( 'change-password', 'PasswordController@index' )->name( 'change-password.index' );
    Route::put( 'change-password', 'PasswordController@update' )->name( 'change-password.update' );
    Route::get( 'receive-bill', 'ReceivedMoneyController@index' )->name( 'received_money.index' );
    Route::post( 'receive-bill', 'ReceivedMoneyController@store' )->name( 'received_money.store' );

} );

// Dept. Office Route Group
Route::group( ['as' => 'dept_office.', 'prefix' => 'dept-office', 'namespace' => 'Dept_Office', 'middleware' => ['auth', 'deptOffice']], function () {

    Route::get( 'dashboard', 'DashboardController@index' )->name( 'dashboard' );
    Route::resource( 'student', 'StudentController' );
    Route::put( 'change_all_status/{id}', 'StudentController@change_all_status' )->name( "student.change_all_status" );
    Route::put( 'change_status_selected', 'StudentController@changeStatusForSelectedStudents' )->name( 'student.change_status_selected' );
    Route::get( 'halls', 'HallsController@index' )->name( 'halls.index' );
    Route::get( 'change-password', 'PasswordController@index' )->name( 'change-password.index' );
    Route::put( 'change-password', 'PasswordController@update' )->name( 'change-password.update' );
    Route::get( 'download/{session_id}', 'StudentController@download' )->name( 'student.download' );
} );

// Hall Office Route Group
Route::group( ['as' => 'hall_office.', 'prefix' => 'hall-office', 'namespace' => 'Hall_Office', 'middleware' => ['auth', 'hallOffice']], function () {

    Route::get( 'dashboard', 'DashboardController@index' )->name( 'dashboard' );
    Route::resource( 'rooms', 'RoomsController' );
    Route::resource( 'allotted-students', 'AllottedStudentsController' );
    Route::put( 'add-money/{student_id}', 'AllottedStudentsController@addMoney' )->name( 'allotted-students.add-money' );
    Route::get( 'allotted-students/details/{student_id}', 'AllottedStudentsController@details' )->name( 'allotted-students.details' );
    Route::resource( 'payment', 'PaymentController' );
    Route::post( 'pay-hall-bill/{student_id}', 'AllottedStudentsController@pay_hall_bill' )->name( 'allotted-students.pay-hall-bill' );
    Route::get( 'change-password', 'PasswordController@index' )->name( 'change-password.index' );
    Route::put( 'change-password', 'PasswordController@update' )->name( 'change-password.update' );
    Route::get( 'pending-students', 'AllottedStudentsController@pendingStudents' )->name( 'pending_students' );
    Route::put( 'pending-students/{student_id}', 'AllottedStudentsController@pendingStudentsUpdate' )->name( 'pending_students.update' );
    Route::get( 'download', 'AllottedStudentsController@download' )->name( 'pending_students.download' );

} );

// Student Route Group
Route::group( ['as' => 'student.', 'prefix' => 'student', 'namespace' => 'Student', 'middleware' => ['auth', 'student']], function () {

    Route::get( 'dashboard', 'DashboardController@index' )->name( 'dashboard' );
    Route::resource( 'coupon', 'CouponController' );
    Route::get( 'transaction', 'TransactionController@index' )->name( 'transaction' );
    Route::get( 'change-password', 'PasswordController@index' )->name( 'change-password.index' );
    Route::put( 'change-password', 'PasswordController@update' )->name( 'change-password.update' );

} );

// Hall Dining Route Group
Route::group( ['as' => 'dining.', 'prefix' => 'dining', 'namespace' => 'Dining', 'middleware' => ['auth', 'dining']], function () {

    Route::get( 'dashboard', 'DashboardController@index' )->name( 'dashboard' );
    Route::resource( 'coupon', 'CouponController' );
    Route::get( 'transaction', 'TransactionController@index' )->name( 'transaction' );
    Route::get( 'change-password', 'PasswordController@index' )->name( 'change-password.index' );
    Route::put( 'change-password', 'PasswordController@update' )->name( 'change-password.update' );

} );
