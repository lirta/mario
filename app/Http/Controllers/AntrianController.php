<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAntrianRequest;
use App\Http\Requests\UpdateAntrianRequest;
use App\Models\Antrian;

class AntrianController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data['pageTitle'] = "Antrian " . date('d-m-Y');
		$data['emptyMessage'] = "Belum ada data";
		$data['antrian'] = Antrian::where('tanggal', date('Y-m-d'))->with('service')->orderBy('id', 'DESC')->paginate(getPaginate());
		return view('admin.antrian.index', $data);
	}

	public function history()
	{
		$data['pageTitle'] = "History Antrian ";
		$data['emptyMessage'] = "Belum ada data";
		$data['antrian'] = Antrian::with('service', 'user')->orderBy('id', 'DESC')->paginate(getPaginate());
		return view('admin.antrian.history', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function progres($id)
	{
		$data = Antrian::find($id);
		if (empty($data)) {
			return redirect()->route('antrian.index')->with('error', 'Data not fonud');
		}
		$data->status = '1';
		$data->save();

		return back()->with('success', 'Success progres antrian');
	}
	public function finish($id)
	{
		$data = Antrian::find($id);
		if (empty($data)) {
			return redirect()->route('antrian.index')->with('error', 'Data not fonud');
		}
		$data->status = '2';
		$data->save();

		return back()->with('success', 'Success finish antrian');
	}
	public function cancel($id)
	{
		$data = Antrian::find($id);
		if (empty($data)) {
			return redirect()->route('antrian.index')->with('error', 'Data not fonud');
		}
		$data->status = '3';
		$data->save();

		return back()->with('success', 'Success cancel antrian');
	}
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreAntrianRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreAntrianRequest $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Antrian  $antrian
	 * @return \Illuminate\Http\Response
	 */
	public function show(Antrian $antrian)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Antrian  $antrian
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Antrian $antrian)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateAntrianRequest  $request
	 * @param  \App\Models\Antrian  $antrian
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateAntrianRequest $request, Antrian $antrian)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Antrian  $antrian
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Antrian $antrian)
	{
		//
	}
}
