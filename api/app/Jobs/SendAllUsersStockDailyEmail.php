<?php

namespace App\Jobs;

use App\Mail\UserStocksDaily;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAllUsersStockDailyEmail implements ShouldQueue
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
		// Send email to all users
		User::chunk(100, function ($users) {
			foreach ($users as $user) {
				Mail::to($user->email)
					->send(new UserStocksDaily($user));
			}
		});
	}
}
