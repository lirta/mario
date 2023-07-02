<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Consumen;
use App\Models\Order;
use App\Models\Partner;
use App\Models\Setting;
use App\Models\User;
use Auth;

class AdminAuthController extends Controller
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
	public function dashboard()
	{
		$data['pageTitle'] = "Dashboard";
		$data['all'] = Antrian::where('tanggal', date('Y-m-d'))->count();
		$data['wait'] = Antrian::where('tanggal', date('Y-m-d'))->where('status', '0')->count();
		$data['finish'] = Antrian::where('tanggal', date('Y-m-d'))->where('status', '2')->count();
		$data['antri'] = Antrian::with('user', 'service')->where('tanggal', date('Y-m-d'))->where('status', '1')->first();
		// dd($data['antri']);
		return view('admin.dashboard.index', $data);
	}
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
		// echo $request->email." | ".$request->password;
		// dd($data);
		if (auth()->guard('admin')->attempt([
			'email'    => $request->email,
			'password' => $request->password,
		])) {
			$user = auth()->user();
			return redirect()->route('admin.dashboard');
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

		$request->session()->invalidate();

		$request->session()->regenerateToken();

		return redirect('/admin/login');
	}
}
