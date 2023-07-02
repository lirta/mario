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
		$data['user'] = User::where('email', Auth::user()->email)->first();
		// dd($data['user']);
		return view('member.dashboard.index', $data);
	}

	public function editProfile(Request $request)
	{
		// dd($request->all());
		$this->validate($request, [
			'fullname' => 'required|string|max:40',
			'email'    => 'required|string|max:90|unique:users,email',
			'phone'    => 'required|numeric|unique:users,mobile',
		]);
		if ($request->password != null) {
			$this->validate($request, [
				'password' => 'required|min:6|confirmed',
			]);

			$user = User::where('member_id', $request->member_id)->first();
			if ($user == null) {
				return redirect()->back()->with('error', 'User not found');
			}

			$user->fullname              = $request->fullname;
			$user->email                 = $request->email;
			$user->mobile_code           = '62';
			$user->mobile                = ($request->phone * 1);
			$user->password              = bcrypt($request->password);
			$user->save();
			return redirect()->back()->with('success', 'Update profile success');
		}

		$user = User::where('member_id', $request->member_id)->first();
		if ($user == null) {
			return redirect()->back()->with('error', 'User not found');
		}

		$user->fullname              = $request->fullname;
		$user->email                 = $request->email;
		$user->mobile_code           = '62';
		$user->mobile                = ($request->phone * 1);
		$user->save();
		return redirect()->back()->with('success', 'Update profile success');
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
