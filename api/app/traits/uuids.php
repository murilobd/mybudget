<?php

namespace App\traits;

use Illuminate\Support\Str;

trait Uuids
{

	/**
	 * Boot function from laravel.
	 */
	protected static function boot()
	{
		parent::boot();

		static::creating(function ($model) {
			// if pass in create([...]) uuid, this uuid will be used instead of creating a new one
			if (empty($model->uuid)) {
				$model->uuid = (string) Str::uuid();
			}
		});
	}
}