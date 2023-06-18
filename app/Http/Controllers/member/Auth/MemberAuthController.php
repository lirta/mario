<?php

namespace App\Http\Controllers\Member\Auth;

use DB;
use Str;
use Auth;
use Mail;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberAuthController extends Controller
{
	public function showLoginForm()
	{

		if (Auth::guard('web')->check()) {
			return redirect()->route('member.dashboard');
		} else {
			return view('member.auth.login');
		}

		return view('member.auth.login');
	}

	public function login(Request $request)
	{
		$this->validate($request, [
			'email'    => 'required|email',
			'password' => 'required',
		]);

		$login = [
			'email' => $request->email,
			'password' => $request->password
		];
		$data = Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'));
		if (auth()->guard('web')->attempt([
			'email'    => $request->email,
			'password' => $request->password,
		])) {
			return redirect()->route('member.dashboard');
		} else {
			return redirect()->back()->with('error', 'Email or Password is incorrect');
		}
	}

	public function dashboard()
	{

		return view('member.dashboard.index');
		// $data['pageTitle']      = "Dashboard";
		// $data['settings']       = Setting::first();
		// $data['vd']             = UserPackage::where('user_id', auth()->user()->id)->sum('vd');
		// $data['walletInProfit'] = WalletVD::where('user_id', Auth::guard('web')->user()->id)->where('type', 'in')->sum('amount');
		// // $data['walletOut']		= WalletVD::where('user_id', Auth::guard('web')->user()->id)->where('type', 'out')->sum('amount');


		// $data['poinIn']      = WalletPoint::where('user_id', Auth::id())->where('type', 'In')->sum('point_amount');
		// $data['poinOut']     = WalletPoint::where('user_id', Auth::id())->where('type', 'Out')->sum('point_amount');
		// $data['saldoWallet'] = getBalanceUser(Auth::id());

		// $data['walletIn']  = Wallet::where('user_id', auth()->user()->id)->where('type', 'Credit')->sum('amount');
		// $data['walletOut'] = Wallet::where('user_id', auth()->user()->id)->where('type', 'Debit')->sum('amount');

		// $data['refferal']     = User::where('referral_by', Auth::id())->count();
		// $data['news']         = News::all();
		// $data['slide']        = NewsPicture::all();
		// $data['archifment']   = Archifment::all();

		// $data['matrix']       = UserMatrix::where('user_id', Auth::id())->latest()->first();
		// $data['profitTrader'] = ProfitTrader::get();

		// $data['userContest'] = UserContest::where('user_id', Auth::id())->get();

		// $data['popup'] = Popup::first();
		// // dd($data['refferal']);
		// // $data['poin'] =
		// return view('member.index', $data);
	}

	public function logout()
	{
		Auth::guard('web')->logout();
		return redirect()->route('member_login');
	}

	public function showForgotPasswordForm()
	{
		$data['titlePage'] = "Forgot Password";
		return view('member.auth.forgot-password', $data);
	}

	public function forgotPassword(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|email',
		]);

		$user = User::where('email', $request->email)->first();
		if ($user) {
			$token = Str::random(64);
			DB::table('password_resets')->insert([
				'email' => $request->email,
				'token' => $token,
				'created_at' => Carbon::now()
			]);


			// Send email
			$subject = 'Reset Password';
			$message = 'Click the link below to reset your password: ' . route('member.reset_password_get', $token);
			// Mail::send('mail.forgetPassword', ['token' => $token], function ($message) use ($request) {
			// 	$message->to($request->email);
			// 	$message->subject('Reset Password');
			// });

			return back()->with('success', 'We have sent you an email to reset your password');
		} else {
			return back()->with('error', 'Email not found');
		}
	}

	public function showResetPasswordForm($token)
	{
		// $data['settings'] = Setting::first();
		$data['token'] = $token;
		return view('member.auth.reset-password', $data);
	}

	public function resetPassword(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|email',
			'password' => 'required|confirmed|min:6',
			'password_confirmation' => 'required',
		]);

		$updatePassword = DB::table('password_resets')
			->where([
				'email' => $request->email,
				'token' => $request->token
			])
			->first();

		if (!$updatePassword) {
			return back()->withInput()->with('error', 'Invalid token!');
		}

		$user = User::where('email', $request->email)->first();
		$user->password = bcrypt($request->password);
		$user->save();

		DB::table('password_resets')->where(['email' => $request->email])->delete();

		return redirect()->route('member_login')->with('success', 'Password changed successfully!');
	}
}
