<?php

namespace App\Exports;

use App\Models\Contacts;
use App\Models\Groups;
use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContactExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
	use Exportable;

    public function collection()
    {
		$data=Contacts::all();
		foreach($data as $contact){
			$user = User::where('id', $contact->user_id)->first();
			$group=Groups::where('id', $contact->group_id)->first();
			$contact->user_id=@$user->username;
			$contact->group_id=@$group->name;
			// dd($contact);
		}

        return Contacts::all();
    }

	public function headings(): array
	{
		return [
			'User',
			'Group',
			'Nama',
			'Phone',
			'Email',
			'Whatsapp',
			'Country',
			'Description',
			'Status',
		];
	}
}
