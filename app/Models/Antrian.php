<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
	use HasFactory;

	public function service()
	{
		return $this->belongsTo(Layanan::class, 'id_layanan');
	}
	public function user()
	{
		return $this->belongsTo(User::class, 'member_id', 'member_id');
	}
}
