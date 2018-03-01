<?php

namespace App;

use App\Notifications\ResetPassword;
use App\UserStock;
use App\traits\UserStockOperations;
use App\traits\Uuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
	use Notifiable, HasApiTokens, Uuids, UserStockOperations;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * Send the password reset notification.
	 *
	 * @param  string  $token
	 * @return void
	 */
	public function sendPasswordResetNotification($token)
	{
		$this->notify(new ResetPassword($token));
	}

	/**
	 * Each user has many stocks
	 *
	 * @return: Illuminate\Database\Eloquent\Concerns\hasMany
	 */
	public function stocks()
	{
		return $this->hasMany(UserStock::class, 'user_id', 'id');
	}
}
