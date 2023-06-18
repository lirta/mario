<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contacts;
use App\Models\Groups;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\ContactExport;
use App\Imports\ContactImport;
use Maatwebsite\Excel\Facades\Excel;


class ContactsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	function __construct()
	{
		$this->middleware('permission:contacts-list|contacts-create|contacts-edit|contacts-delete|contacts-banned', ['only' => ['index', 'show']]);
		$this->middleware('permission:contacts-create', ['only' => ['create', 'store']]);
		$this->middleware('permission:contacts-edit', ['only' => ['edit', 'update']]);
		$this->middleware('permission:contacts-delete', ['only' => ['destroy']]);
	}

	public function export()
	{
		return Excel::download(new ContactExport, 'contacts.xlsx');
	}
	public function import(Request $request)
	{
		$validatedData = $request->validate([
			'file' => 'required'
		]);
		$file = $request->file('file');
		$fileName = $file->getClientOriginalName();
		$file->move('uploads', $fileName);
		Excel::import(new ContactImport, public_path('/uploads/' . $fileName));
		return back()->with('success', 'All good!');
	}
	public function index()
	{
		$data['pageTitle'] = "All Contacts";
		$data['emptyMessage'] = "No data found";
		$data['contacts'] = Contacts::with('user', 'group')->paginate(getPaginate());
		$data['settings'] = Setting::first();
		return view('admin.contacts.index', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$data['pageTitle'] = "Add New Contact";
		$data['groups'] = Groups::all();
		$data['users'] = User::all();
		$data['settings'] = Setting::first();
		return view('admin.contacts.create', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreContactsRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$validatedData = $request->validate([
			'name' => 'required',
			'code' => 'required',
			'phone' => 'required',
			'email' => 'required',
			'country' => 'required',
			'status' => 'required',
			'desc' => 'required'
		]);
		// dd($request->all());
		$contacts = new Contacts();
		$contacts->user_id = $request->user;
		$contacts->group_id = $request->group;
		$contacts->name = $request->name;
		$contacts->phone_code = $request->code;
		$contacts->phone = $request->phone;
		$contacts->email = $request->email;
		$contacts->country = $request->country;
		$contacts->is_public = $request->status;
		$contacts->wa_valid = 1;
		$contacts->description = $request->desc;
		$contacts->save();
		return back()->with('success', 'Contact created successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Contacts  $contacts
	 * @return \Illuminate\Http\Response
	 */
	public function show(Contacts $contacts)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Contacts  $contacts
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$data['pageTitle'] = "Edit Contact";
		$data['groups'] = Groups::all();
		$data['users'] = User::all();
		$data['contact'] = Contacts::find($id);
		$data['settings'] = Setting::first();

		return view('admin.contacts.edit', $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateContactsRequest  $request
	 * @param  \App\Models\Contacts  $contacts
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$validatedData = $request->validate([
			'name' => 'required',
			'code' => 'required',
			'phone' => 'required',
			'email' => 'required',
			'country' => 'required',
			'status' => 'required',
			'desc' => 'required'
		]);
		// dd($request->all());
		$contacts = Contacts::find($id);
		$contacts->user_id = $request->user;
		$contacts->group_id = $request->group;
		$contacts->name = $request->name;
		$contacts->phone_code = $request->code;
		$contacts->phone = $request->phone;
		$contacts->email = $request->email;
		$contacts->country = $request->country;
		$contacts->is_public = $request->status;
		$contacts->wa_valid = 1;
		$contacts->description = $request->desc;
		$contacts->save();
		return back()->with('success', 'Contact updated successfully.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Contacts  $contacts
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id)
	{
		$contacts = Contacts::find($id);
		if ($contacts == null) {
			return back()->with('error', 'Contact not found.');
		}
		$contacts->delete();
		return back()->with('success', 'Contact deleted successfully.');
	}
}
