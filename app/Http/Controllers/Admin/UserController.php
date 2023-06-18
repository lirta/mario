<?php

namespace App\Http\Controllers\Admin;

use Cache;
use Carbon\Carbon;
use App\Models\Bank;
use App\Models\Poin;
use App\Models\User;
use App\Models\Setting;
use App\Models\UserBank;
use App\Models\WalletVD;
use App\Models\Permission;
use App\Models\UserPackage;
use Illuminate\Support\Str;
use App\Models\WalletProfit;
use Illuminate\Http\Request;
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
		$data['settings'] 		= Setting::first();
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
	public function delete($id)
	{
		$user = User::find($id);
		$user->delete();
		$ren = SettingProfile::where('user_id', $id)->first();
		$oldPic = @$ren->logo;
		if ($oldPic != null) {
			$pthPic = \base_path() . "/public/assets/images/rental/" . $oldPic;
			if (file_exists($pthPic)) {
				unlink($pthPic);
			}
		}
		$ren->delete();
		return back()->with('success', 'Success delete user');
	}
	public function show($id)
	{
		$data['pageTitle']		= "Detail Member";
		$data['emptyMessage']	= "No data found";

		return view('admin.User.show');
	}
}
