<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;;

use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data['pageTitle'] = "All Settings";
		$data['emptyMessage'] = "No data found";
		$data['settings'] = Setting::first();
		// dd($data['settings']);
		$data['data'] = Setting::paginate(getPaginate());
		return view('admin.settings.index', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$data['pageTitle'] = "Create Setting";
		return view('admin.settings.create', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreSettingRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Setting  $setting
	 * @return \Illuminate\Http\Response
	 */
	public function show(Setting $setting)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Setting  $setting
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$data['pageTitle'] = "Edit Setting";
		$data['settings'] = Setting::first();
		$data['setting'] = Setting::findOrFail($id);
		return view('admin.settings.edit', $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateSettingRequest  $request
	 * @param  \App\Models\Setting  $setting
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|email',
			'instagram' => 'required|url',
			'youtube' => 'required|url',
			'address' => 'required',
			'pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			'icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		]);

		$res = $request->file('pic');
		if ($res) {
			$ext = time() . '.' . $res->getClientOriginalExtension();
			$picName = Str::random(10) . '.' . $ext;
			$res->move(\base_path() . "/public/assets/images/logo", $picName);
			// move pic old
			$oldPic = Setting::findOrFail($id)->logo;
			if ($oldPic) {
				$oldPicPath = public_path('assets/images/logo/' . $oldPic);

				if (file_exists($oldPicPath)) {
					unlink($oldPicPath);
				}
			}
		} else {
			$picName = Setting::findOrFail($id)->logo;
		}

		$icon = $request->file('icon');
		if ($icon) {
			$ext = time() . '.' . $icon->getClientOriginalExtension();
			$iconName = Str::random(10) . '.' . $ext;
			$icon->move(\base_path() . "/public/assets/images/logo", $iconName);
			// move pic old
			$oldIcon = Setting::findOrFail($id)->icon;
			if ($oldIcon) {
				$oldIconPath = public_path('assets/images/logo/' . $oldIcon);

				if (file_exists($oldIconPath)) {
					unlink($oldIconPath);
				}
			}
		} else {
			$iconName = Setting::findOrFail($id)->favicon;
		}

		$setting = Setting::findOrFail($id);
		$setting->name = $request->name;
		$setting->email = $request->email;
		$setting->instagram = $request->instagram;
		$setting->youtube = $request->youtube;
		$setting->address = $request->address;
		$setting->is_mt = $request->is_mt == null ? 0 : 1;
		$setting->logo = $picName;
		$setting->favicon = $iconName;
		$setting->save();
		return back()->with('success', 'Setting updated successfully');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Setting  $setting
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Setting $setting)
	{
		//
	}
}
