<?php

namespace App\Exports;

use App\Models\Contact;
use App\Models\Contacts;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ApiContactExport implements FromCollection, WithHeadings
{
    protected $id;
    function __construct($id) {
        $this->id = $id;
    }
    public function collection()
    {
        // return Contacts::all();
        $ontacts = Contacts::query()
            ->where('user_id',$this->id)
            // ->select('id','user_id','group_id','name','phone_code','phone','email','country','description','label')
            ->select('id','group_id','name','phone_code','phone','email','country','description','label')
            ->orderBy('id','desc')
            ->get();
        return $ontacts;
    }
    public function headings(): array
	{
		return [
			'id',
			// 'user_id',
			'group_id',
			'name',
			'phone_code',
			'phone',
			'email',
			'country',
			'description',
			'label',
		];
	}
}
