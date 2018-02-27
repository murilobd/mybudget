<?php

namespace App;

use App\StockInfos;
use App\traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Murilobd\GoogleFinanceStocks\Facade\GoogleFinanceStocks;
use Murilobd\GoogleFinanceStocks\GoogleFinanceStocksException;

class Stock extends Model
{
	use Uuids;

	protected $fillable = [
		'exchange', 'symbol', 'name'
	];

	/**
	 * Each stock has one infos
	 *
	 * @return: Illuminate\Database\Eloquent\Concerns\hasOne
	 */
	public function infos()
	{
		return $this->hasOne(StockInfos::class, 'stock_id', 'id');
	}

	/**
	 * Update stock infos from Google Finance API
	 *
	 * @return: boolean
	 */
	public function updateInfosFromGoogle()
	{
		$infos = $this->infos()->firstOrCreate([]);
		$infos->updateFromGoogle();

		return $this->infos();
	}
}
