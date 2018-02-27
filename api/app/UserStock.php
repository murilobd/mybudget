<?php

namespace App;

use App\Stock;
use App\StockInfos;
use App\User;
use App\traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class UserStock extends Model
{
	use Uuids;
	
	protected $fillable = [
		'user_id', 'stock_id', 'quantity', 'date_buy', 'date_sell', 'price_buy', 'price_sell', 'exchange_fee_buy', 'exchange_fee_sell', 
	];

	protected $dates = [
		'date_buy',
		'date_sell'
	];

	protected $casts = [
		'quantity' => 'double',
		'price_buy' => 'double',
		'price_sell' => 'double',
		'exchange_fee_buy' => 'double',
		'exchange_fee_sell' => 'double',
	];


	/**
	 * Each stock belongs to a user
	 *
	 * @return: Illuminate\Database\Eloquent\Concerns\belongsTo
	 */
	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	/**
	 * Each stock belongs to a stock
	 *
	 * @return: Illuminate\Database\Eloquent\Concerns\belongsTo
	 */
	public function stock()
	{
		return $this->belongsTo(Stock::class, 'stock_id', 'id');
	}

	/**
	 * Each stock has one info
	 *
	 * @return: Illuminate\Database\Eloquent\Concerns\hasOne
	 */
	public function stockInfos()
	{
		return $this->hasOne(StockInfos::class, 'stock_id', 'id');
	}

	public function toArray()
	{
		$infos = $this->stockInfos;

		return [
			'uuid' => $this->uuid,
			'symbol' => $this->stock->symbol,
			'name' => $this->stock->name,
			'qtt' => $this->quantity,
			'buy_price' => $this->price_buy,
			'exchange_fee' => $this->exchange_fee_buy,
		];
	}
}
