<?php

namespace App\Jobs;

use App\Stock;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateUsingStocks implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		// Get all used stocks and update them
		DB::table('user_stocks')
			->select('stock_id')
			->orderBy('stock_id')
			->distinct()
			->chunk(100, function ($stocks){
				foreach ($stocks as $stock) {
					$stock_infos = Stock::find($stock->stock_id)->infos;
					if (!$stock_infos->updateFromGoogle()) {
						Log::emergency('Stock ' . $stock_infos->stock->symbol . ' did not update. Error: ' . $e->getMessage());
					}
				}
			});
	}
}
