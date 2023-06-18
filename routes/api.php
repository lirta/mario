<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BasicController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\SendWebhookController;
use App\Http\Controllers\Api\WhatsappController;
use App\Http\Controllers\Api\ApiWalletController;
use App\Http\Controllers\Api\Auth\CodeController;
use App\Http\Controllers\Api\ApiContactController;
use App\Http\Controllers\Api\Auth\RegisterController;


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

// Route::middleware(['BlockAccessWeb',])->group(function () {

Route::namespace('Api')->name('api.')->group(function () {
	Route::get('unauthenticate', [BasicController::class, 'unauthenticate'])->name('unauthenticate');
	Route::namespace('Auth')->group(function () {
		Route::post('/send-code-email', [CodeController::class, 'sendCode']);
		Route::post('/send-code-login', [CodeController::class, 'sendCodeLogin']);
		Route::post('/send-code-mobile', [CodeController::class, 'sendCodeMobile']);
		Route::post('/send-code-sms', [CodeController::class, 'sendCodeSMS']);
		Route::post('/send-code-wa', [CodeController::class, 'sendCodeWA']);
		Route::post('/login', [App\Http\Controllers\Api\Auth\LoginController::class, 'login']);
		// Route::post('/login-type', [App\Http\Controllers\Api\Auth\LoginController::class, 'loginType']);
		// Route::post('/loginotp', [App\Http\Controllers\Api\Auth\LoginController::class, 'loginCode']);
		// Route::post('/loginotpmobile', [App\Http\Controllers\Api\Auth\LoginController::class, 'loginCodeMobile']);
        Route::get('/register/{id}', [App\Http\Controllers\Api\Auth\RegisterController::class, 'show'])->name('show');
        Route::post('/register', [App\Http\Controllers\Api\Auth\RegisterController::class, 'register']);
	    Route::post('password/email', 'ForgotPasswordController@sendResetCodeEmail');
	    Route::post('password/verify-code', 'ForgotPasswordController@verifyCode');
	    Route::post('password/reset', 'ResetPasswordController@reset');
	    Route::get('get-package', [App\Http\Controllers\Api\BasicController::class, 'getPackage']);
	    Route::get('get-country', [App\Http\Controllers\Api\Auth\RegisterController::class, 'getCountry']);
	    Route::get('get-payment', [App\Http\Controllers\Api\BasicController::class, 'getPayment']);
	    Route::post('register-package', [RegisterController::class, 'registerPackage']);
	    Route::get('get-register-package', [RegisterController::class, 'getPackage']);
	    Route::get('get-register-payment', [RegisterController::class, 'getRegsiterPayment']);

	    // Route::get('webhook', [App\Http\Controllers\Api\BasicController::class, 'getWebhook']);

        Route::get('webhook', [SendWebhookController::class, 'store']);
        Route::post('webhook', [SendWebhookController::class, 'store']);

	});

	Route::middleware('auth.api:sanctum')->name('user.')->prefix('user')->group(function () {
		Route::get('logout', [App\Http\Controllers\Api\Auth\LoginController::class, 'logout']);
		Route::get('authorization', [App\Http\Controllers\Api\AuthorizationController::class, 'authorization'])->name('authorization');
		Route::get('get-user-package', [App\Http\Controllers\Api\AuthorizationController::class, 'getUserPackage']);
	    Route::middleware(['checkStatusApi'])->group(function(){
                Route::post('profile-setting', [App\Http\Controllers\Api\UserController::class, 'submitProfile']);
                Route::get('get-balance', [App\Http\Controllers\Api\UserController::class, 'getBalance']);
                Route::get('/profile', [App\Http\Controllers\Api\UserController::class, 'profile']);

                //whatsapp
                Route::get('/whatsapp-brodcast', [WhatsappController::class, 'index']);
                Route::post('/whatsapp-sendmessage', [WhatsappController::class, 'store']);
                Route::get('/whatsapp/template', [WhatsappController::class, 'getTemplate']);
                Route::post('/whatsapp/create-template', [WhatsappController::class, 'createTemplate']);
                Route::get('/whatsapp/get-language', [WhatsappController::class, 'getLanguage']);
                Route::get('/whatsapp/get-category-template', [WhatsappController::class, 'getCategoryTemplate']);
                Route::post('/whatsapp/send-message', [WhatsappController::class, 'sendMessage']);
                Route::get('/whatsapp/get-messages', [WhatsappController::class, 'getConversation']);
                Route::post('/whatsapp/send-open-conversation', [WhatsappController::class, 'sendOpenConversation']);

                Route::get('/get-contacts', [ApiContactController::class, 'index']);
                Route::post('/add-contact', [ApiContactController::class, 'store']);
                Route::post('/update-contact', [ApiContactController::class, 'update']);
                Route::get('/get-detail-contact', [ApiContactController::class, 'show']);
                Route::post('/delete-contact', [ApiContactController::class, 'destroy']);
                Route::delete('/delete-all-contact', [ApiContactController::class, 'destroyAll']);
                Route::post('/set-tag-contact', [ApiContactController::class, 'setTag']);

                Route::get('/get-referrals', [UserController::class, 'referrals']);

                //export contact
                Route::get('/contact/export', [ApiContactController::class, 'export']);
                // Route::post('/contacts/import', [ContactController::class, 'import']);
                Route::post('/contact-import', [ApiContactController::class, 'import']);

                //tag
                Route::get('/get-tags', [TagController::class, 'index']);
                Route::post('/add-tag', [TagController::class, 'store']);
                Route::delete('/delete-tag', [TagController::class, 'destroy']);
                Route::post('/update-tag', [TagController::class, 'update']);

                Route::post('withdraw', [ApiWalletController::class, 'store']);
                Route::get('get-withdraw', [ApiWalletController::class, 'withdraws']);

                Route::get('get-wallet', [ApiWalletController::class, 'index']);
                Route::get('get-wallet-balance', [ApiWalletController::class, 'balance']);

                //databank
                Route::get('get-data-bank', [ApiWalletController::class, 'banks']);
                Route::get('get-bank', [ApiWalletController::class, 'create']);
                Route::post('add-bank', [ApiWalletController::class, 'addBank']);
                Route::post('update-bank', [ApiWalletController::class, 'update']);
                Route::delete('bank-delete', [ApiWalletController::class, 'destroy']);

            });
	});
});
