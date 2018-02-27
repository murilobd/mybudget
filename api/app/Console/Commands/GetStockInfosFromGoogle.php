<?php

namespace App\Console\Commands;

use App\Stock;
use Illuminate\Console\Command;

class GetStockInfosFromGoogle extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'mybudget:getStockInfosFromGoogle {exchange} {symbol}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Get infos from google from a given stock';

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
		$exchange = $this->argument('exchange');
		$symbol = $this->argument('symbol');
		$stock = Stock::where('exchange', $exchange)
						->where('symbol', $symbol)
						->get()
						->first();

		if (!$stock) {
			$this->error("Stock {$exchange}:{$symbol} not found");
			return false;
		}

		$infos = $stock->infos()->firstOrCreate([]);
		$infos->updateFromGoogle();

		$this->info("Atualizado com sucesso!");
	}
}
