<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLayananRequest;
use App\Http\Requests\UpdateLayananRequest;
use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data['pageTitle'] = "Layanan";
		$data['emptyMessage'] = "Belum ada data";
		$data['layanan'] = Layanan::orderBy('id', 'DESC')->paginate(getPaginate());

		return view('admin.layanan.index', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$data['pageTitle'] = "Layanan-Create";
		$data['emptyMessage'] = "Belum ada data";

		return view('admin.layanan.create', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreLayananRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'layanan' => 'required',
			'waktu' => 'required',
			'des' => 'required'
		]);

		$save = new Layanan();
		$save->layanan = $request->layanan;
		$save->perkiraan_waktu = $request->waktu;
		$save->description = $request->des;
		$save->save();

		return redirect()->route('layanan.index')->with('success', 'Layanan Created Success');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Layanan  $layanan
	 * @return \Illuminate\Http\Response
	 */
	public function show(Layanan $layanan)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Layanan  $layanan
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$data['pageTitle'] = "Layanan-Edit";
		$layanan = Layanan::find($id);
		if (empty($layanan)) {
			return redirect()->route('layanan.index')->with('error', 'Data not found');
		} else {
			$data['layanan'] = $layanan;
			return view('admin.layanan.edit', $data);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateLayananRequest  $request
	 * @param  \App\Models\Layanan  $layanan
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$this->validate($request, [
			'layanan' => 'required',
			'waktu' => 'required',
			'des' => 'required'
		]);
		if (empty($request->id)) {
			return redirect()->route('layanan.index')->with('error', 'Data not found');
		}
		$update = Layanan::find($request->id);
		if (empty($update)) {
			return redirect()->route('layanan.index')->with('error', 'Data not found');
		}
		$update->layanan = $request->layanan;
		$update->perkiraan_waktu = $request->waktu;
		$update->description = $request->des;
		$update->save();

		return redirect()->route('layanan.index')->with('success', 'Layanan updated success');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Layanan  $layanan
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$delete = Layanan::find($id);
		if (empty($delete)) {
			return redirect()->route('layanan.index')->with('error', 'Data not found');
		}
		$delete->delete();

		return redirect()->route('layanan.index')->with('success', 'Layanan deleted success');
	}
}
