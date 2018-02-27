<?php

namespace App\traits;

use App\Stock;

trait UserStockOperations
{
	/**
	 * Get consolidate stocks infos from user
	 *
	 * @return: array
	 */
	public function getConsolidatedStocksInfos()
	{
		$user_stocks = $this->stocks;

		$stocks_id = array_unique($user_stocks->map(function ($user_stock){
			return $user_stock->stock_id;
		})->all());

		$stocks = [];
		foreach ($stocks_id as $stock_id) {
			$infos = $this->getSummarizedStockInfos($stock_id);
			array_push($stocks, $infos);
		}
		
		return $stocks;
	}

	/**
	 * Get all infos from one user's stock and consolidate it
	 *
	 * @param: int $stock_id
	 * @return: array
	 */
	private function getSummarizedStockInfos($stock_id)
	{
		$user_stocks = $this->stocks()->where('stock_id', $stock_id)->get();
		$stocks_summary = $this->summarizeStockInfos($user_stocks);

		$stock = Stock::find($stock_id);
		$stock_infos = $stock->updateInfosFromGoogle()->get()->first();

		$profit = $this->getProfit($stock_infos, $stocks_summary);
		$profit_percentage = $this->getProfitPercentage($stock_infos, $stocks_summary);

		return [
			'uuid' => $user_stocks->first()->stock->uuid,
			'symbol' => $user_stocks->first()->stock->symbol,
			'quantity' => $stocks_summary->quantity,
			'avg_buy_price' => $stocks_summary->avg_price,
			'last_price' => $stock_infos->price,
			'price_variation' => $stock_infos->variation,
			'last_date' => $stock_infos->updated_at->toIso8601String(),
			'total_profit' => $profit,
			'total_profit_percentage' => $profit_percentage
		];
	}

	/**
	 * Summarize stock infos (quantity, exchange fees, average of buy price)
	 *
	 * @param: App\UserStock $user_stocks
	 * @return: array
	 */
	private function summarizeStockInfos($user_stocks)
	{
		$summary = new \stdClass;
		$summary->avg_price = 0;
		$summary->exchange_fee = 0;
		$summary->quantity = 0;
		$summary->total = 0;

		foreach ($user_stocks as $user_stock) {
			$summary->avg_price += $user_stock->price_buy;
			$summary->exchange_fee += $user_stock->exchange_fee_buy;
			$summary->quantity += $user_stock->quantity;
			$summary->total += ($user_stock->price_buy * $user_stock->quantity) + $user_stock->exchange_fee_buy;
		}
		
		$summary->avg_price = $summary->avg_price / $user_stocks->count();

		return $summary;
	}

	/**
	 * Return profit of a stock
	 *
	 * @param: App\StockInfos $stock_infos
	 * @param: array $stocks_summary
	 * @return: double
	 */
	private function getProfit($stock_infos, $stocks_summary)
	{
		return (double) ($stock_infos->price - $stocks_summary->avg_price) * $stocks_summary->quantity - $stocks_summary->exchange_fee;
	}

	/**
	 * Return profit in percentage of a stock
	 *
	 * @param: App\StockInfos $stock_infos
	 * @param: array $stocks_summary
	 * @return: double
	 */
	private function getProfitPercentage($stock_infos, $stocks_summary)
	{
		return (($stock_infos->price * $stocks_summary->quantity) / $stocks_summary->total - 1) * 100;
	}
}
