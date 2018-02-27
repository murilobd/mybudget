<?php

namespace App\Console\Commands;

use App\Holiday;
use App\Jobs\SendAllUsersIsHolidayEmail;
use App\Jobs\SendAllUsersStockDailyEmail;
use App\Jobs\UpdateUsingStocks;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendUsersStockDailyEmail extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'mybudget:sendUsersStockDailyEmail';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send to all users Stocks Daily Email';

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
		$today = Carbon::today();

		// On weekends, do nothing
		$isWeekend = $today->isWeekend();
		if ($isWeekend)
			return false;

		// On holidays, send HolidayEmail to all users
		$holiday = Holiday::where('date', $today->toDateString())->get()->first();
		if ($holiday) {
			SendAllUsersIsHolidayEmail::dispatch($holiday)->onQueue('stocks_daily');
			return false;
		}

		// On regular days, send StockDailyEmail to all users
		SendAllUsersStockDailyEmail::withChain([
			new UpdateUsingStocks
		])
			->dispatch()
			->onQueue('stocks_daily');

		return true;
	}


}
