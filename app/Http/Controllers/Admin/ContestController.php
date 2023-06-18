<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContestRequest;
use App\Http\Requests\UpdateContestRequest;
use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\ContestTrims;
use App\Models\package;
use App\Models\Setting;
use Illuminate\Http\Request;

class ContestController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data['pageTitle']    = "All Contests";
		$data['emptyMessage'] = "No data found";
		$data['settings']  = Setting::first();
		$data['contests']     = Contest::with('contest_trims')->paginate(getPaginate());
		// dd($data['contests']->toarray());
		return view('admin.contest.index', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$data['pageTitle'] = "Create New Contest";
		$data['settings']  = Setting::first();
		$data['package']  = Package::all();
		return view('admin.contest.create', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreContestRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'trims' => 'required',
		]);
		// dd($request->all());
		$contest = new Contest();
		$contest->name = $request->name;
		$contest->save();

		foreach ($request->trims as $value) {
			$trim = new ContestTrims();
			$trim->contest_id = $contest->id;
			$trim->package_id = $value;
			$trim->save();
		}
		return back()->with('success', 'Contest created successfully');
	}
	public function section($id)
	{
		$data['contest']  = Contest::find($id);
		$data['pageTitle'] = "Section " . $data['contest']->name;
		$data['settings']  = Setting::first();
		$data['sections']  = ContestSection::where('contest_id', $id)->get();
		return view('admin.contest.section', $data);
	}
	public function section_create($id)
	{
		$data['contest']  = Contest::find($id);
		$data['pageTitle'] = "Create New Section " . $data['contest']->name;
		$data['settings']  = Setting::first();
		$data['package']  = Package::all();
		return view('admin.contest.section_create', $data);
	}

	public function section_store(Request $request, $id)
	{
		$this->validate($request, [
			'name' 		=> 'required',
			'desc' 		=> 'required',
			'affiliate' => 'required|numeric',
			'vd' 		=> 'required|numeric',
		]);
		// dd($request->all());
		$section = new ContestSection();
		$section->contest_id = $id;
		$section->name = $request->name;
		$section->description = $request->desc;
		$section->affiliate = $request->affiliate;
		$section->bonus_vd = $request->vd;
		$section->save();
		return back()->with('success', 'Contest created successfully');
	}

	public function section_edit($id)
	{
		$data['pageTitle'] = "Edit Section ";
		$data['settings']  = Setting::first();
		$data['section']  = ContestSection::find($id);
		return view('admin.contest.section_edit', $data);
	}

	public function section_update(Request $request, $id)
	{
		$this->validate($request, [
			'name' 		=> 'required',
			'desc' 		=> 'required',
			'affiliate' => 'required|numeric',
			'vd' 		=> 'required|numeric',
		]);
		// dd($request->all());
		$section = ContestSection::find($id);
		$section->name = $request->name;
		$section->description = $request->desc;
		$section->affiliate = $request->affiliate;
		$section->bonus_vd = $request->vd;
		$section->save();
		return back()->with('success', 'Contest created successfully');
	}

	public function section_delete($id)
	{
		$section = ContestSection::find($id);
		$section->delete();
		return back()->with('success', 'Contest created successfully');
	}

	public function show(Contest $contest)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Contest  $contest
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$data['pageTitle'] = "Edit Contest";
		$data['settings']  = Setting::first();
		$data['contest']  = Contest::with('contest_trims')->find($id);
		$data['package']  = Package::all();
		// dd($data['contest']->toarray());
		return view('admin.contest.edit', $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateContestRequest  $request
	 * @param  \App\Models\Contest  $contest
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'name' => 'required',
			'trims' => 'required',
		]);
		// dd($request->all());
		$contest = Contest::find($id);
		$contest->name = $request->name;
		$contest->save();

		ContestTrims::where('contest_id', $id)->delete();
		foreach ($request->trims as $value) {
			$trim = new ContestTrims();
			$trim->contest_id = $contest->id;
			$trim->package_id = $value;
			$trim->save();
		}
		return back()->with('success', 'Contest update successfully');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Contest  $contest
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		Contest::find($id)->delete();
		ContestTrims::where('contest_id', $id)->delete();
		ContestSection::where('contest_id', $id)->delete();
		return back()->with('success', 'Contest deleted successfully');
	}
}
