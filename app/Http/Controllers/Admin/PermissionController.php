<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GroupPermission;
use App\Models\PermissionGroup;
use App\Models\Setting;
use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
	function __construct()
	{
		$this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index', 'store']]);
		$this->middleware('permission:permission-create', ['only' => ['create', 'store']]);
		$this->middleware('permission:permission-edit', ['only' => ['edit', 'update']]);
		$this->middleware('permission:permission-delete', ['only' => ['destroy']]);
	}

	public function index()
	{
		// dd("test");
		$data['pageTitle']    = "All Permissions";
		$data['emptyMessage'] = "No data found";
		$data['permissions']  = Permission::paginate(getPaginate());
		$data['groups']       = PermissionGroup::all();
		$data['id']        = 0;
		$data['settings'] = Setting::first();
		return view('admin.permission.index', $data);
	}

	public function filter(Request $request)
	{
		$data['pageTitle']    = "All Permissions";
		$data['emptyMessage'] = "No data found";
		if ($request->input('group') == '0') {
			return redirect()->route('permission.index');
		}
		$data['permissions']  = Permission::where('permission_group_id', $request->input('group'))->paginate(getPaginate());
		$data['groups']       = PermissionGroup::all();
		$data['id']        = $request->input('group');
		$data['settings'] = Setting::first();
		return view('admin.permission.index', $data);
	}

	public function create()
	{
		$data['pageTitle'] = "Create New Permission";
		$data['groups']       = PermissionGroup::orderBy('id', 'desc')->get();
		$data['settings'] = Setting::first();
		// dd($data['groups']);
		return view('admin.permission.create', $data);
	}

	public function group(Request $request)
	{
		$this->validate($request, [
			'nameG' => 'required|unique:permission_groups,name',
		]);
		// dd($request->input('nameG'));
		PermissionGroup::create(['name' => $request->input('nameG')]);
		return back()->with('success', 'Group Permission has been created');
	}

	public function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required|unique:permissions,name',
			'group' => 'required'
		]);
		if ($request->input('group') == '0') {
			return back()->with('warning', 'Select a group');
		}
		Permission::create([
			'name' => $request->input('name'),
			'permission_group_id' => $request->input('group')
		]);
		return back()->with('success', 'Permission has been created');
	}

	public function edit($id)
	{
		$data['pageTitle'] = "Edit Permission";
		$data['permission'] = Permission::find($id);
		$data['groups']       = PermissionGroup::all();
		$data['settings'] = Setting::first();
		return view('admin.permission.edit', $data);
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'name' => 'required|unique:permissions,name,' . $id,
			'group' => 'required'
		]);
		if ($request->input('group') == '0') {
			return back()->with('warning', 'Select a group');
		}
		$permission = Permission::findOrFail($id);
		$permission->name = $request->input('name');
		$permission->permission_group_id = $request->input('group');
		$permission->save();
		return back()->with('success', 'Permission has been updated');
	}

	public function delete($id)
	{
		$permission = Permission::findOrFail($id);
		$permission->delete();
		DB::table('role_has_permissions')->where('permission_id', $id)->delete();
		return back()->with('success', 'Permission has been deleted');
	}
}
