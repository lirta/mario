<?php

use App\Events\EveryoneEvent;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\Member\AntrianMemberController;
use App\Http\Controllers\Member\Auth\MemberAuthController;
use App\Http\Controllers\Member\LayananMemberController;
use App\Http\Controllers\Member\RegisterMemberController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UseripController;

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

// Route::get('/login', 'Admin\AdminController@index')->name('admin.login');

// Route::get('/test', [TestController::class, 'index']);

Route::get('/send', function () {
	broadcast(new EveryoneEvent());
	return response('Sent');
});

Route::get('/receiver', function () {
	return view('receiver');
});

Route::get('/lokasi', function () {
	$location = geoip()->getLocation();

	// Lakukan tindakan lain dengan data lokasi

	return $location;
});

// home
// Route::get('/', [PageController::class, 'index'])->name('index');


//member area
Route::get('/', [MemberAuthController::class, 'showLoginForm'])->name('member_login');


Route::get('/member/login', [MemberAuthController::class, 'showLoginForm'])->name('member_login');
Route::post('/member/login', [MemberAuthController::class, 'login'])->name('member.login');
Route::get('/member/logout', [MemberAuthController::class, 'logout'])->name('member.logout');

//resgistermember
Route::get('/member/formRegister', [RegisterMemberController::class, 'showRegisterForm'])->name('member_register');
Route::post('/member/register', [RegisterMemberController::class, 'register'])->name('member.register');
// Route::get('/member/register-check-referral/{id}', [RegisterMemberController::class, 'checkReferral'])->name('member.checkReferral');
Route::get('/member/register-check-referral/', [RegisterMemberController::class, 'checkReferral'])->name('member.checkReferral');
// forgot password member
Route::get('/member/forgot-password', [MemberAuthController::class, 'showForgotPasswordForm'])->name('member.forgot_password');
Route::post('/member/forgot-password', [MemberAuthController::class, 'forgotPassword'])->name('member.forgot_password');
Route::get('/member/reset-password-form/{token}', [MemberAuthController::class, 'showResetPasswordForm'])->name('member.reset_password_get');
Route::post('/member/reset-password', [MemberAuthController::class, 'resetPassword'])->name('member.reset_password_post');

// member area
Route::get('/', function () {
	return redirect()->route('member.dashboard');
});
Auth::routes();

Route::group(['prefix' => 'member', 'namespace' => 'Member'], function () {
	Route::group(['middleware' => 'auth:web', 'language'], function () {
		// dashboard
		Route::get('/', [MemberAuthController::class, 'dashboard'])->name('member.dashboard');
		Route::get('/layanan', [LayananMemberController::class, 'index'])->name('member.layanan');
		Route::get('/antrian', [AntrianMemberController::class, 'index'])->name('member.antrian');
	});
});
// admin area 
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

	Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin_login');

	Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login');
	Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
	Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin_login');
	Route::get('/test', [TestController::class, 'index'])->name('test_index');
	Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login');
	Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');


	Route::group(['middleware' => 'auth:admin'], function () {
		// dashboard
		Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');

		// layanan
		Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
		Route::get('/layanan-create', [LayananController::class, 'create'])->name('layanan.create');
		Route::post('/layanan-store', [LayananController::class, 'store'])->name('layanan.store');
		Route::get('/layanan-edit/{id}', [LayananController::class, 'edit'])->name('layanan.edit');
		Route::post('/layanan-update', [LayananController::class, 'update'])->name('layanan.update');
		Route::get('/layanan-delete/{id}', [LayananController::class, 'destroy'])->name('layanan.delete');


		// antrian
		Route::get('/antrian', [AntrianController::class, 'index'])->name('antrian.index');

		// antrian history
		Route::get('/antrian-history', [AntrianController::class, 'history'])->name('antrian.history');

		Route::get('/data', [UseripController::class, 'admin'])->name('data.admin');
	});
});
