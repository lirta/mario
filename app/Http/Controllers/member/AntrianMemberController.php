<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use Illuminate\Http\Request;

class AntrianMemberController extends Controller
{
	public function index()
	{
		$data['pageTitle'] = "Antrian";
		$data['emptyMessage'] = "Belum ada data";
		$data['antrian'] = Antrian::orderBy('id', 'DESC')->paginate(getPaginate());
		return view('member.antrian.index', $data);
	}
}
