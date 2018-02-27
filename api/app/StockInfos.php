<?php

namespace App;

use App\Stock;
use App\traits\Uuids;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Murilobd\GoogleFinanceStocks\Facade\GoogleFinanceStocks;
use Murilobd\GoogleFinanceStocks\GoogleFinanceStocksException;

class StockInfos extends Model
{
	use Uuids;

	protected $fillable = [
		'date', 'low', 'high', 'price', 'variation',
	];

	protected $dates = [
		'date'
	];

	protected $casts = [
		'low' => 'double',
		'high' => 'double',
		'price' => 'double',
		'variation' => 'double',
	];

	/**
	 * Each infos belongs to a stock
	 *
	 * @return: Illuminate\Database\Eloquent\Concerns\belongsTo
	 */
	public function stock()
	{
		return $this->belongsTo(Stock::class, 'stock_id', 'id');
	}

	/**
	 * Update stock infos from Google Finance API
	 *
	 * @return: $this
	 */
	public function updateFromGoogle()
	{
		$stock = $this->stock;

		// Only update stock infos if last update was more than 15 minutes ago
		// AND if hour is > 10am
		if (Carbon::now()->diffInMinutes($this->updated_at) <= 15 || Carbon::now()->hour < 10)
			return $this;

		try {
			$google_infos = GoogleFinanceStocks::requestStockInfos($stock->exchange, $stock->symbol);
		} catch (GoogleFinanceStocksException $e) {
			Log::emergency('Stock: ' . $stock->symbol . 'Failed updating from google: ' . $e->getMessage());
			return false;
		}

		// If any of those values are empty, means stock isn't opened yet to update values
		if ($google_infos->open == '' || $google_infos->low == '' || $google_infos->high == '')
			return $this;

		$this->update([
			'date' => Carbon::now(),
			'low' => $google_infos->low,
			'high' => $google_infos->high,
			'price' => $google_infos->price,
			'variation' => $google_infos->variation
		]);

		return $this;
	}
}
