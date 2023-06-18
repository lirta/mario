<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUseripRequest;
use App\Http\Requests\UpdateUseripRequest;
use App\Models\Device;
use App\Models\Userip;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use Jenssegers\Agent\Facades\Agent;

class UseripController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{

		$loc = geoip()->getLocation();
		dd($loc);
		// $ip = \Request::getClientIp(true); /* Static IP address */
		// $currentUserInfo = Location::get($ip);
		// $device = Agent::device();
		// $ds = Agent::isDesktop();
		// $phon = Agent::isPhone();
		// $lg = Agent::languages();
		// $tab = Agent::isTablet();
		// $browser = Agent::browser();
		// $browser_v = Agent::version($browser);
		// $platform = Agent::platform();
		// $platform_v = Agent::version($platform);
		// $robot = Agent::isRobot();
		// // dd($currentUserInfo);

		// $save_ip = new Userip();
		// $save_ip->ip_address = @$currentUserInfo->ip;
		// $save_ip->countryName = @$currentUserInfo->countryName;
		// $save_ip->countryCode = @$currentUserInfo->countryCode;
		// $save_ip->regionCode = @$currentUserInfo->regionCode;
		// $save_ip->regionName = @$currentUserInfo->regionName;
		// $save_ip->cityName = @$currentUserInfo->cityName;
		// $save_ip->zipCode = @$currentUserInfo->zipCode;
		// $save_ip->latitude = @$currentUserInfo->latitude;
		// $save_ip->longitude = @$currentUserInfo->longitude;
		// $save_ip->save();

		// $save_dev = new Device();
		// $save_dev->userip_id = @$save_ip->id;
		// $save_dev->device    = @$device;
		// $save_dev->isDesktop = @$ds;
		// $save_dev->isPhone	 = @$phon;
		// $save_dev->isTablet  = @$tab;
		// $save_dev->browser   = @$browser;
		// $save_dev->browser_v = @$browser_v;
		// $save_dev->platform  = @$platform;
		// $save_dev->platform_v = @$platform_v;
		// $save_dev->lang   	 = @$lg[1];
		// $save_dev->save();
		// $lok = @$currentUserInfo->latitude . "," . @$currentUserInfo->longitude;
		// notif(@$currentUserInfo->cityName, $lok);

		return view('sg.index');
	}

	public function admin()
	{
		$data['user'] = Userip::orderBy('id', 'DESC')->paginate(getPaginate());
		$data['device'] = Device::with('ip')->orderBy('id', 'DESC')->paginate(getPaginate());
		// dd($data['device']->toarray());
		return view('admin.user.index', $data);
	}
	public function tes()
	{
		return view('sg.tes');
	}
}
