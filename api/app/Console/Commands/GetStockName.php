<?php

namespace App\Console\Commands;

use App\Stock;
use Illuminate\Console\Command;
use Murilobd\GoogleFinanceStocks\Facade\GoogleFinanceStocks;

class GetStockName extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'mybudget:getStocksName';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Get Stock\'s name';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$stocks = Stock::whereNull('name')->get();
		
		$bar = $this->output->createProgressBar(count($stocks));

		foreach ($stocks as $stock) {
			$_infos = GoogleFinanceStocks::requestStockInfos($stock->exchange, $stock->symbol);
			$stock->update([
				'name' => $_infos->name
			]);
			$bar->advance();
		}
	}
}
