<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
	public function __construct()
	{
		// $this->middleware('guest')->except('logout');
		// $this->middleware('guest:admin')->except('logout');
		// $this->middleware('guest:writer')->except('logout');
	}
	public function showLoginForm()
	{
		if (Auth::guard('admin')->check()) {
			return redirect()->route('admin.dashboard');
		} else {
			return view('admin.auth.adminLogin');
		}

		$data['data'] = 'Test';
		return view('admin.auth.adminLogin', $data);
	}

	/**
	 * Handle an incoming admin authentication request.
	 *
	 * @param  \App\Http\Requests\Auth\LoginRequest  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function login(Request $request)
	{

		$this->validate($request, [
			'email'    => 'required|email',
			'password' => 'required',
		]);
		$login = [
			'username' => $request->email,
			'password' => $request->password
		];

		$data = Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'));

		if (auth()->guard('admin')->attempt([
			'email'    => $request->email,
			'password' => $request->password,
		])) {
			$user = auth()->user();
			return redirect('/admin/dashboard');
		} else {
			return redirect()->back()->with('warning', __('Credentials doesn\'t match.'));
		}
	}

	/**
	 * Destroy an authenticated session.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function logout(Request $request)
	{
		Auth::guard('admin')->logout();

		if (Auth::guard('admin')->check()) {
			$request->session()->invalidate();

			$request->session()->regenerateToken();
			return redirect()->route('admin_login');
		} elseif (Auth::guard('user')->check()) {
			$request->session()->invalidate();

			$request->session()->regenerateToken();
			return redirect()->route('member_login');
		}


		// return redirect('/');
	}
}
