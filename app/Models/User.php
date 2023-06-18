<?php

namespace App\Models;

use App\Models\Country;
use App\Models\Generation;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable, HasApiTokens;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $guarded = ['id'];
	protected $guard = 'user';
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token', 'code', 'password_confirmation'
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
		'address' => 'object',
		'ver_code_send_at' => 'datetime'
	];

	protected $data = [
		'data' => 1
	];

	public function withdraw()
	{
		return $this->hasMany(Withdrawal::class, 'user_id');
	}

	public function login_logs()
	{
		return $this->hasMany(UserLogin::class);
	}

	public function transactions()
	{
		return $this->hasMany(Transaction::class)->orderBy('id', 'desc');
	}

	public function deposits()
	{
		return $this->hasMany(Deposit::class)->where('status', '!=', 0);
	}

	public function withdrawals()
	{
		return $this->hasMany(Withdrawal::class)->where('status', '!=', 0);
	}

	public function referral()
	{
		return $this->hasMany(User::class, 'ref_by');
	}

	public function bids()
	{
		return $this->hasMany(Bid::class);
	}

	public function wins()
	{
		return $this->hasMany(Winner::class);
	}

	public function commissions()
	{
		return $this->hasMany(CommissionLog::class);
	}


	// SCOPES

	// public function getFullnameAttribute()
	// {
	// 	return $this->firstname . ' ' . $this->lastname;
	// }

	public function scopeActive()
	{
		return $this->where('status', 1);
	}

	public function scopeBanned()
	{
		return $this->where('status', 0);
	}

	public function scopeEmailUnverified()
	{
		return $this->where('ev', 0);
	}

	public function scopeSmsUnverified()
	{
		return $this->where('sv', 0);
	}
	public function scopeEmailVerified()
	{
		return $this->where('ev', 1);
	}

	public function scopeSmsVerified()
	{
		return $this->where('sv', 1);
	}
	public function membership()
	{
		return $this->hasOne(Membership::class, 'id', 'membership_id');
	}
	public function country()
	{
		return $this->hasOne(Country::class, 'phonecode', 'country');
	}
	public function referralBy()
	{
		return $this->belongsTo(User::class, 'ref_by', 'id');
	}
	public function user_package()
	{
		return $this->belongsTo(UserPackage::class, 'user_package_id', 'id');
	}

	public function user_bank()
	{
		return $this->hasMany(UserBank::class, 'user_id', 'id')->with('bank');
	}

	public function user_tag()
	{
		return $this->hasMany(UserTag::class, 'user_id', 'id');
	}

	// ==========================================================

	public function wallet()
	{
		return $this->hasMany(Wallet::class, 'user_id', 'id');
	}

	public function wallet_vd()
	{
		return $this->hasMany(WalletVD::class, 'user_id', 'id');
	}

	public function wallet_profit()
	{
		return $this->hasMany(WalletProfit::class, 'user_id', 'id');
	}

	public function poin()
	{
		return $this->hasMany(Poin::class, 'user_id', 'id');
	}
	public function order()
	{
		return $this->hasMany(Order::class, 'user_id', 'id');
	}
	public function order_affiliate()
	{
		return $this->hasMany(Order::class, 'affiliate', 'id');
	}
	public function grouptrim()
	{
		return $this->hasMany(GroupTrims::class, 'user_id', 'id');
	}
	public function package()
	{
		return $this->belongsTo(Package::class, 'package_id', 'id');
	}
	public function group()
	{
		return $this->belongsTo(Groups::class, 'group_id');
	}
	public function sum_vd()
	{
		return $this->hasMany(UserPackage::class);
	}
	public function wallet_comission()
	{
		return $this->hasMany(WalletComissi::class);
	}
	public function ref_by()
	{
		return $this->belongsTo(User::class, 'referral_by', 'id');
	}
	public function childs()
	{
		return $this->hasMany(User::class, 'referral_by', 'id')->whereNotNull('group_id');
	}
    public function generation()
	{
		return $this->hasMany(Generation::class);
	}
    public function generationCount1()
	{
		return $this->hasMany(Generation::class)->where('type', '1');
	}
    public function generationCount2()
	{
		return $this->hasMany(Generation::class)->where('type', '2');
	}
    public function generationCount3()
	{
		return $this->hasMany(Generation::class)->where('type', '3');
	}
    public function generationCount4()
	{
		return $this->hasMany(Generation::class)->where('type', '4');
	}
    public function generationCount5()
	{
		return $this->hasMany(Generation::class)->where('type', '5');
	}
}
