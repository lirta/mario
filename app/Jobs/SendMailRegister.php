<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
// use App\Mail\SendEmail;
use App\Mail\EmailCode;

class SendMailRegister implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	protected $sendMail;
	protected $subject;
	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($sendMail, $subject)
	{
		$this->sendMail = $sendMail;
		$this->subject = $subject;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$email = new EmailCode($this->sendMail, $this->subject);
		Mail::to($this->sendMail)->send($email);
	}
}
