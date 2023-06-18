<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Validator;
use Illuminate\Http\Request;

class LayananMemberController extends Controller
{
	public function index()
	{

		$data['pageTitle'] = "Layanan";
		$data['emptyMessage'] = "Belum ada data";
		$data['layanan'] = Layanan::orderBy('id', 'DESC')->paginate(getPaginate());
		return view('member.layanan.index', $data);
	}
}
