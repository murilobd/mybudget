<?php

namespace App\Mail;

use App\Holiday;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HolidayEmail extends Mailable
{
	use Queueable, SerializesModels;

	public $holiday;
	public $date;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Holiday $holiday)
	{
		$this->holiday = $holiday;
		$this->date = Carbon::today()->format('Y-m-d');
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->subject('[My Budget] No trades today.')
					->markdown('emails.user.stocks_holiday');
	}
}
