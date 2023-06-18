<?php

namespace App\Imports;

use App\Models\Contacts;
use Maatwebsite\Excel\Concerns\ToModel;

class ContactImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Contacts([
            'name'        => $row[0],
            'phone_code'  => $row[1],
            'phone'       => $row[2],
            'email'       => $row[3],
            'country'     => $row[4],
            'is_public'   => $row[5],
            'wa_valid'    => $row[6],
            'description' => $row[7],
        ]);
    }
}
