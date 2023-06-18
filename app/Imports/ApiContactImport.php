<?php

namespace App\Imports;

use App\Models\Contact;
use App\Models\Contacts;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ApiContactImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // 'id',
        // 'user_id',
        // 'group_id',
        // 'name',
        // 'phone_code',
        // 'phone',
        // 'email',
        // 'country',
        // 'description',
        // 'label',
        if(!Contacts::where('phone', '=', $row['phone'])->where('phone_code', '=', @$row['phone_code'])->where('user_id',auth()->user()->id)->exists()) {
            return new Contacts([
                'user_id'     => auth()->user()->id,
                'name'        => @$row['name'],
                'phone_code'  => $row['phone_code'],
                'phone'       => $row['phone'],
                'email'       => @$row['email'],
                'country'     => @$row['country'],
                'is_public'   => '0',
                'wa_valid'    => '0',
                'label'       => @$row['label'],
                'description' => @$row['description'],
            ]);
        }
    }
}
