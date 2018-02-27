<?php

namespace App\Jobs;

use App\Holiday;
use App\Mail\HolidayEmail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAllUsersIsHolidayEmail implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public $holiday;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(Holiday $holiday)
	{
		$this->holiday = $holiday;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		// Send email to all users
		User::chunk(50, function ($users) {
			$emails = [];
			foreach ($users as $user) {
				array_push($emails, $user->email);
			}
			
			Mail::to(env('MAIL_FROM_ADDRESS'))
				->bcc($emails)
				->send(new HolidayEmail($this->holiday));
		});
	}
}
