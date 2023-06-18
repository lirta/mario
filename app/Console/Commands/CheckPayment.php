<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Bonus;
use App\Models\Wallet;
use App\Models\UserPackage;
use Illuminate\Console\Command;
use App\Models\UserPackagePayment;

class CheckPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $listpayment = UserPackagePayment::with(['payment'])->where('status','PENDING')->get();
        foreach($listpayment as $payment){
            $checkPayment = paymentRequestStatus($payment->gateway_id);

            $userDt       = User::where('id',$payment->user_id)->first();
            $chkReferral  = User::with(['user_package'])->where('id',$userDt->referral_by)->first();

               if(@$checkPayment->status=='SUCCEEDED'){
                     $payment->status       = 'SUCCEEDED';
                     $payment->payment_date = Carbon::parse(@$checkPayment->updated)->format('Y-m-d H:i:s');;
                     $payment->save();

                     $userPackage         = UserPackage::where('id',$payment->user_package_id)->first();
                     $userPackage->status = '1';
                     $userPackage->save();

                     $user = User::where('id',$payment->user_id)->update([
                         'status'    => '3',
                         'expires_at' => now()->addDays(@$chkReferral->user_package->package->time_line)
                     ]);

                     //user_package_id->user,sponsor_value->package,sponsor_value->user_package
                     if($userDt->referral_by){
                         $trx                   = $payment->gateway_id;
                         $bonus                 = new Bonus();
                         $bonus->user_id        = $chkReferral->id;
                         $bonus->trx            = $trx;
                         $bonus->amount         = $payment->amount*(@$chkReferral->user_package->sponsor_value/100);
                         $bonus->value          = @$chkReferral->user_package->sponsor_value;
                         $bonus->origin_amount  = $payment->amount;
                         $bonus->source_user_id = $payment->user_id;
                         $bonus->description    = 'Referral Bonus';
                         $bonus->type           = 'Referral';
                         $bonus->save();

                         //wallet
                         $wallet              = new Wallet();
                         $wallet->user_id     = $chkReferral->id;
                         $wallet->amount      = $bonus->amount;
                         $wallet->trx         = $trx;
                         $wallet->type        = 'Credit';
                         $wallet->description = $payment->amount;
                         $wallet->save();

                         //send message to whatsapp & eail

                     }

               }
        }
    }
}
