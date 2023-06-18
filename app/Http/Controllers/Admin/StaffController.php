<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Admin;
use App\Models\Setting;
use DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class StaffController extends Controller
{
	function __construct()
    {
        //  $this->middleware('permission:staff-list|staff-create|staff-edit|staff-delete', ['only' => ['index','show']]);
        //  $this->middleware('permission:staff-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:staff-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:staff-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
    	$data['pageTitle'] = "All Staff";
    	$data['emptyMessage'] = "No data found";
    	$data['staffs'] = Admin::paginate(getPaginate());
		$data['settings'] = Setting::first();
    	return view('admin.staff.index', $data);
    }

	public function profile($id)
	{
		$data['pageTitle'] = "Staff Profile";
		$data['staff'] = Admin::findOrFail($id);
		$data['settings'] = Setting::first();
		return view('admin.staff.profile', $data);
	}


    public function create()
    {
    	$data['pageTitle'] = "Staff Create";
    	$data['permissions'] = Permission::all();
		$data['roles'] = Role::all();
		$data['settings'] = Setting::first();
    	return view('admin.staff.create', $data);
    }


    public function store(Request $request)
    {
    	$request->validate([
            'firstname'       => 'required|string|max:40',
            'lastname'       => 'required|string|max:40',
            'username'   => 'required|string|max:40|unique:admins',
            'email'      => 'required|string|max:40|unique:admins',
            'permission' => 'required',
            'status'     => 'required',
            'password'   => 'required|string|min:6|confirmed',
			'pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			'mobile' => 'required|numeric|min:6',
			'mobile_code' => 'required|numeric|min:1',
        ]);
		$res = $request->file('pic');
		$ext = $res->getClientOriginalExtension();
			$picName= Str::random(10) . '.' . $ext;
			$res->move(\base_path() . "/public/assets/images/staff", $picName  );
			$picUrl=asset('assets/images/staff');
			$picPos=$picName;

        $staff                = new Admin();
        $staff->firstname     = $request->firstname;
        $staff->lastname      = $request->lastname;
        $staff->username      = $request->username;
        $staff->email         = $request->email;
        $staff->status        = $request->status;
		$staff->mobile		  = ltrim($request->mobile, '0');
		$staff->mobile_code	  = $request->mobile_code;
        $staff->password      = Hash::make($request->password);
        $staff->show_password = $request->password;
		$staff->photo 		  = $picPos;
		$staff->photo_url	  = $picUrl;
        $staff->save();

		$staff->assignRole($request->input('roles'));

       return back()->with('success','Staff has been updated');
    }

    public function edit($id)
    {
    	$data['pageTitle'] = "Staff Update";
    	$data['staff'] = Admin::findOrFail($id);
		$data['roles'] = Role::all();
		$data['userRole'] = $data['staff']->roles->all();
		$data['settings'] = Setting::first();
    	return view('admin.staff.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'firstname' => 'required|string|max:40',
            'lastname'  => 'required|string|max:40',
            'username'  => 'required|string|max:40|unique:admins,username,'.$id,
            'email'     => 'required|string|max:90|unique:admins,email,'.$id,
			'pic' 		=> 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			'mobile'	 => 'required|numeric|min:9',
			'mobile_code' => 'required|numeric|min:1',
        ]);
		$pass="";
		$picUrl="";
		if (!empty($request->password)) {
			$request->validate([
				'password' => 'required|string|min:6|confirmed',
			]);
			$pass=$request->password;
		}

		$res = $request->file('pic');
		if (!empty($res)) {
			$ext = $res->getClientOriginalExtension();
			$picName= Str::random(10) . '.' . $ext;
			$res->move(\base_path() . "/public/assets/images/staff", $picName  );
			$picUrl=asset('assets/images/staff');
			$picPos=$picName ;
			//create delete old pic
			$memberPic = Admin::where('id', $id)->first();
			$oldPic = $memberPic->photo;
			if ($oldPic != null) {
				$pthPic = \base_path() . "/public/assets/images/staff/" . $oldPic;
			if (file_exists($pthPic)) {
				unlink($pthPic);
			}
			}

		}

        $staff                = Admin::find($id);
        $staff->firstname     = $request->firstname;
        $staff->lastname      = $request->lastname;
        $staff->username      = $request->username;
        $staff->email         = $request->email;
        $staff->staff_access  = $request->permission;
        $staff->show_password = !empty($request->password) ? $pass : $staff->show_password;
        $staff->password      = !empty($request->password) ? Hash::make($pass) : $staff->password;
		$staff->mobile		  = ltrim($request->mobile, '0');
		$staff->mobile_code	  = $request->mobile_code;
		$staff->photo_url     = $picUrl == "" ? $staff->photo_url : $picUrl;
        $staff->photo         = !empty($request->pic) ? $picPos : $staff->photo;
        $staff->save();

		if (!empty($request->roles)) {
			DB::table('model_has_roles')->where('model_id',$id)->delete();
			$staff->assignRole($request->input('roles'));
		}

		return back()->with('success','Staff has been updated');
    }


    public function delete($id)
    {
        $staffDelete = Admin::where('id', $id)->first();
		if(!@$staffDelete){
			return redirect()->back()->with('warning', 'Staff not found');
		}
		$oldPic = $staffDelete->foto;
			if ($oldPic != null) {
				$pthPic = \base_path() . "/public/assets/images/staff/" . $oldPic;
			if (file_exists($pthPic)) {
				unlink($pthPic);
			}
			}
        $staffDelete->delete();

        return back()->with('success','The Staff has been updated');

    }
}
