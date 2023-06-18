<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermissionGroup;
use App\Models\Setting;
use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
	function __construct()
	{
		$this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
		$this->middleware('permission:role-create', ['only' => ['create', 'store']]);
		$this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
		$this->middleware('permission:role-delete', ['only' => ['destroy']]);
	}

	public function index()
	{
		$data['pageTitle'] = "All Roles";
		$data['emptyMessage'] = "No data found";
		$data['roles'] = Role::paginate(getPaginate());
		$data['settings'] = Setting::first();
		return view('admin.roles.index', $data);
	}
	public function create()
	{
		$data['pageTitle'] = "Create New Role";
		$data['emptyMessage'] = "No data found";
		$data['settings'] = Setting::first();
		$dtpermission = array();
		$idGroup = Permission::groupBy('permission_group_id')->select('permission_group_id')->get();
		foreach ($idGroup as $key => $value) {
			$group = PermissionGroup::where('id', $value->permission_group_id)->first();
			$dPermission = Permission::where('permission_group_id', $value->permission_group_id)->get();
			$permission = array();
			foreach ($dPermission as  $per) {
				array_push($permission, [
					'id' => $per->id,
					'name' => $per->name,
				]);
			}
			array_push($dtpermission, [
				'group' => $group->name,
				'permission' => $permission,
			]);
		}
		$data['groupPermissions'] = $dtpermission;
		return view('admin.roles.create', $data);
	}
	public function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required|unique:roles,name',
			'permission' => 'required',
		]);

		$role = Role::create(['name' => $request->input('name')]);
		$role->syncPermissions($request->permission);
		return back()->with('success', 'Roles has been created');
	}
	public function show($id)
	{
		$data['pageTitle'] = "Role Details";
		$data['role'] = Role::find($id);
		$data['emptyMessage'] = "No data found";
		$data['rolePermissions'] = DB::table("role_has_permissions")->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')->select('name')->where("role_has_permissions.role_id", $id)
			->get();
		$data['settings'] = Setting::first();

		return view('admin.roles.show', $data);
	}
	public function edit($id)
	{
		$data['pageTitle'] = "Edit Role";
		$data['settings'] = Setting::first();
		$data['role'] = Role::find($id);
		// $data['permissions'] = Permission::all();
		$data['rolePermissions'] = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
			->get();


		$dtpermission = array();
		$idGroup = Permission::groupBy('permission_group_id')->select('permission_group_id')->get();
		foreach ($idGroup as $key => $value) {
			$group = PermissionGroup::where('id', $value->permission_group_id)->first();
			$dPermission = Permission::where('permission_group_id', $value->permission_group_id)->get();
			$permission = array();
			foreach ($dPermission as  $per) {
				array_push($permission, [
					'id' => $per->id,
					'name' => $per->name,
				]);
			}
			array_push($dtpermission, [
				'group' => $group->name,
				'permission' => $permission,
			]);
		}
		$data['groupPermissions'] = $dtpermission;
		return view('admin.roles.edit', $data);
	}
	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'name' => 'required',
			'permission' => 'required',
		]);
		$role = Role::find($id);
		$role->name = $request->input('name');
		$role->save();
		$role->syncPermissions($request->permission);

		return back()->with('success', 'Roles has been updated');
	}
	public function delete($id)
	{
		DB::table("roles")->where('id', $id)->delete();

		return back()->with('success', 'Roles has been deleted');
	}
}
