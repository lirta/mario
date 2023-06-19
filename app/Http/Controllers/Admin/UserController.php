<?php

namespace App\Http\Controllers\Admin;

use Cache;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\SettingProfile;
use App\Models\Withdraw;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
	public function tes()
	{
		return "tes";
	}
	public function index()
	{
		$data['pageTitle'] 		= "All Member";
		$data['emptyMessage'] 	= "No data found";
		$data['user'] 			= User::orderBy('id', 'DESC')->paginate(getPaginate());
		return view('admin.User.index', $data);
	}

	public function actived($id)
	{
		$user = User::find($id);
		$user->status = '1';
		$user->save();
		return back()->with('success', 'Success Activited user');
	}
	public function banned($id)
	{
		$user = User::find($id);
		$user->status = '0';
		$user->save();
		return back()->with('success', 'Success Banned user');
	}
}
