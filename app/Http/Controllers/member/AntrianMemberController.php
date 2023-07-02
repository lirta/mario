<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Layanan;
use Auth;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class AntrianMemberController extends Controller
{
	public function index()
	{
		$data['pageTitle'] = "Antrian " . date('d-m-Y');
		$data['emptyMessage'] = "Belum ada data";
		$data['antrian'] = Antrian::where('tanggal', date('Y-m-d'))->with('service')->paginate(getPaginate());
		return view('member.antrian.index', $data);
	}
	public function create()
	{
		$data['pageTitle'] = "Create Antrian " . date('d-m-Y');
		$data['emptyMessage'] = "Belum ada data";
		$data['layanan'] = Layanan::orderBy('id', 'DESC')->paginate(getPaginate());

		return view('member.antrian.create', $data);
	}
	public function store(Request $request)
	{
		$this->validate($request, [
			'service' => 'required'
		]);
		if ($request->service == 0) {
			return redirect()->route('member.antrian.create')->with('error', 'Selected the service');
		}
		$day = date('D-d') . "-";
		$no_antri = IdGenerator::generate(['table' => 'antrians', 'length' => 10, 'prefix' => $day, 'field' => 'no_antrian', 'reset_on_prefix_change' => true, 'reset_on_field_change' => true, 'digit' => '330']);
		// dd(Auth::user()->member_id);
		$save = new Antrian();
		$save->tanggal = date('Y-m-d');
		$save->no_antrian = $no_antri;
		$save->member_id = Auth::user()->member_id;
		$save->id_layanan = $request->service;
		$save->save();

		return redirect()->route('member.antrian')->with('success', 'Success created antrian');
	}

	public function history()
	{
		$data['pageTitle'] = "History Antrian ";
		$data['emptyMessage'] = "Belum ada data";
		$data['antrian'] = Antrian::where('member_id', Auth::user()->member_id)->with('service')->orderBy('id', 'DESC')->paginate(getPaginate());

		return view('member.antrian.history', $data);
	}
}
