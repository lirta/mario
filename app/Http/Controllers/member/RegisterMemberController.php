<?php

namespace App\Http\Controllers\Member;

use Validator;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class RegisterMemberController extends Controller
{
	public function showRegisterForm()
	{
		// dd($data['banks']->toarray());
		$data['titlePage'] = "Register";
		return view('member.auth.register', $data);
	}

	public function register(Request $request)
	{
		// dd($request->all());
		$validator = Validator::make($request->all(), [
			'fullname' => 'required|string|max:40',
			'email'    => 'required|string|max:90|unique:users,email',
			'phone'    => 'required|numeric|unique:users,mobile',
			'password' => 'required|min:6|confirmed',
			'address'  => 'required',
		]);
		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}

		$phone = User::where('mobile', ($request->phone * 1))->first();
		$email = User::where('email', $request->email)->first();
		if (@$email) {
			return redirect()->back()->with('error', __('Email already exists!'));
		}
		if (@$phone) {
			return redirect()->back()->with('error', __('Phone number already exists!'));
		}
		$member_id = IdGenerator::generate(['table' => 'users', 'length' => 10, 'prefix' => 'MP', 'field' => 'member_id', 'reset_on_prefix_change' => true, 'reset_on_field_change' => true, 'digit' => '332580']);
		// dd($member_id);
		$user                        = new User();
		$user->member_id             = $member_id;
		$user->fullname              = $request->fullname;
		$user->email                 = $request->email;
		$user->mobile_code           = '62';
		$user->mobile                = ($request->phone * 1);
		$user->password              = bcrypt($request->password);
		$user->address               = $request->address;

		$user->save();
		return redirect()->route('member_login')->with('success', 'Registration Successful');
	}
	public function _checkReferral($id)
	{
		echo "
        <script>
          var input2 = document.getElementById('referral_name');
          input2.value = 'admin-tst';
         alert('This is a simple message.');
        </script>
        ";
	}
	public function checkReferral(Request $request)
	{
		// echo "aa";
		// $msg = "This is a simple message.";
		// return response()->json(array('msg'=> $msg), 200);
		$referral = User::where('member_id', $request->referral)->first();
		if (@$referral) {
			echo "
                <script>
                document.getElementById('referral_data').style.display = 'block';
                document.getElementById('warning_referral').style.display = 'none';
                var input2 = document.getElementById('referral_name');
                input2.value = '$referral->fullname';
                var input1 = document.getElementById('referral_email');
                input1.value = '$referral->email';
                </script>
                ";
		} else {
			echo "
            <script>
                document.getElementById('warning_referral').style.display = 'block';
                document.getElementById('referral_data').style.display = 'none';
                var input2 = document.getElementById('referral_name');
                input2.value = '';
                var input1 = document.getElementById('referral_email');
                input1.value = '';
            </script>
            ";
		}
	}
}
