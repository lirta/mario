<?php

namespace App\Console\Commands;

use App\Models\Credit;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Message;
use App\Models\WhatsApp;
use App\Models\ContactTag;
use App\Models\Conversation;
use App\Models\WhatsappMessage;
use Illuminate\Console\Command;
use App\Models\WhatsappTemplate;

class WhatsappSendCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:whatsappsend';

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
        $data = WhatsappMessage::where('message_status',0)->where('schedule','<=',now())->get();
        foreach ($data as $key => $value) {
            $template = WhatsappTemplate::where('id',$value->template_id)->first();
            $getCredit = getCredit($value->user_id);

            if($value->message_type == 'Individual'){
                foreach (json_decode($value->type_variable) as $key => $variable) {
                    $contact = Contact::where('id',$variable)->where('wa_valid',1)->first();

                    if($contact){
                        $country  = Country::where('phonecode',$contact->phone_code)->first();
                        $WhatsApp = WhatsApp::where('country_id',$country->id)->first();

                        if($getCredit >= $WhatsApp->blazingwa_bir){

                            $data = sendTextTemplate($template,$contact);
                            // dd($data);
                            if(@$data->messages[0]->id){
                                $chkConversation = Conversation::where('receiver',$contact->phone_code.$contact->phone)->where('user_id',$value->user_id)->first();
                                if(!@$chkConversation){
                                    $chkConversation               = new Conversation();
                                    $chkConversation->receiver   = $contact->phone_code.$contact->phone;
                                    $chkConversation->user_id      = $value->user_id;
                                    $chkConversation->save();
                                }
                                $message                     = new Message();
                                $message->whatsappmessage_id = $value->id;
                                $message->conversation_id    = $chkConversation->id;
                                $message->user_id            = $value->user_id;
                                $message->template_id        = $template->id;
                                $message->contact_id         = $contact->id;
                                $message->message_id         = $data->messages[0]->id;
                                $message->message_status     = 'success';
                                $message->message_to         = $contact->phone_code.($contact->phone*1);
                                $message->save();

                                //update credit
                                $credit              = new Credit();
                                $credit->user_id     = $value->user_id;
                                $credit->amount      = $WhatsApp->blazingwa_bir;
                                $credit->trx         = $message->id;
                                $credit->type        = 'Out';
                                $credit->description = 'Send Whatsapp Message';
                                $credit->save();

                            }
                            else {

                                $message                     = new Message();
                                $message->whatsappmessage_id = $value->id;
                                $message->user_id            = $value->user_id;
                                $message->template_id        = $template->id;
                                $message->contact_id         = $contact->id;
                                $message->message_status     = 'failed';
                                $message->message_to         = $contact->phone_code.($contact->phone*1);
                                $message->description        = 'Invalid Whatsapp Number';
                                $message->save();

                                $contactUpdate = Contact::find($contact->id);
                                $contactUpdate->wa_valid = 2;
                                $contactUpdate->description = __('Invalid Whatsapp Number');
                                $contactUpdate->save();
                            }
                        }
                    }
                }
            } else {
                foreach (json_decode($value->type_variable) as $key => $variable) {
                    // $dataT = ContactTag::where('tag_id',$tag)->get();

                        $dataT = ContactTag::select('contact_id')
                        ->where('tag_id',$variable)
                        ->groupBy('contact_id')
                        ->get();

                    foreach ($dataT as $key => $valueContact) {
                        $contact = Contact::where('id',$valueContact->contact_id)->first();
                        if(@$contact){

                            $country  = Country::where('phonecode',$contact->phone_code)->first();
                            $WhatsApp = WhatsApp::where('country_id',$country->id)->first();

                            if($getCredit >= @$WhatsApp->blazingwa_bir){
                                    $chkMessage = Message::where('whatsappmessage_id',$value->id)->where('contact_id',$contact->id)->first();
                                    if(!@$chkMessage){
                                        $data = sendTextTemplate($template,$contact);
                                        // dd($data);
                                        if(@$data->messages[0]->id){

                                            $chkConversation = Conversation::where('receiver',$contact->phone_code.$contact->phone)->where('user_id',$value->user_id)->first();
                                            if(!@$chkConversation){
                                                $chkConversation           = new Conversation();
                                                $chkConversation->receiver = $contact->phone_code.$contact->phone;
                                                $chkConversation->user_id  = $value->user_id;
                                                $chkConversation->save();
                                            }

                                            $message                     = new Message();
                                            $message->whatsappmessage_id = $value->id;
                                            $message->conversation_id    = $chkConversation->id;
                                            $message->user_id            = $value->user_id;
                                            $message->template_id        = $template->id;
                                            $message->contact_id         = $contact->id;
                                            $message->message_id         = $data->messages[0]->id;
                                            $message->message_status     = 'success';
                                            $message->message_to         = $contact->phone_code.($contact->phone*1);
                                            $message->save();

                                            //update credit
                                            $credit              = new Credit();
                                            $credit->user_id     = $value->user_id;
                                            $credit->amount      = $WhatsApp->blazingwa_bir;
                                            $credit->trx         = $message->id;
                                            $credit->type        = 'Out';
                                            $credit->description = 'Send Whatsapp Message';
                                            $credit->save();

                                        }
                                        else {

                                            $message                     = new Message();
                                            $message->whatsappmessage_id = $value->id;
                                            $message->user_id            = $value->user_id;
                                            $message->template_id        = $template->id;
                                            $message->contact_id         = $contact->id;
                                            $message->message_status     = 'failed';
                                            $message->message_to         = $contact->phone_code.($contact->phone*1);
                                            $message->description        = 'Invalid Whatsapp Number';
                                            $message->save();

                                            $contactUpdate              = Contact::find($contact->id);
                                            $contactUpdate->wa_valid    = 2;
                                            $contactUpdate->description = __('Invalid Whatsapp Number');
                                            $contactUpdate->save();
                                        }
                                }
                            }
                        }
                    }


                }
            }

            WhatsappMessage::where('id',$value->id)->update([
                'message_status'=>1
            ]);

        }
    }
}
