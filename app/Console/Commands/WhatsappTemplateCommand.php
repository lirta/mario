<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WhatsappTemplate;
use App\Models\WhatsappTemplateComponent;
use App\Models\WhatsappTemplateComponentButton;

class WhatsappTemplateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:whatsapptemplate';

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
        // Generated @ codebeautify.org
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v15.0/110350401953638/message_templates?&access_token=EAAMmUBZBV7cIBAKC2RAvZCX0Ml1C2NhSIhBr3Au34BcRNdt4wU6i7ZClHAUBhXI1Wis2TjjZBptt7L54JgwPaVq0dZCTBHkpSACKZBLs871xsc7ZAS0mrppvjmhrBtwLvkY3ZBz5WCvhnySwQzH4uEfbaGBrkZADsGDuSXRUxVqWvCZCX4pPENROnFFjvBoCCi5CCeEZB5RMebyNgZDZD');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $responseBody = json_decode($result);
        WhatsappTemplateComponent::truncate();
        WhatsappTemplateComponentButton::truncate();
        foreach ($responseBody->data as $key) {
                if($key->language=='id' or $key->language=='en_US' or $key->language=='en_GB'){
                $dtTemplate = WhatsappTemplate::where('template_id',$key->id)->first();
                if(@$dtTemplate){
                    $template = WhatsappTemplate::find($dtTemplate->id);
                    $template->name        = $key->name;
                    $template->language    = $key->language;
                    $template->status      = $key->status;
                    $template->category    = $key->category;
                    $template->template_id = $key->id;
                    $template->save();
                }else{
                    $template              = new WhatsappTemplate();
                    $template->name        = $key->name;
                    $template->language    = $key->language;
                    $template->status      = $key->status;
                    $template->category    = $key->category;
                    $template->template_id = $key->id;
                    $template->save();
                }

                foreach ($key->components as $components) {
                    $dtComponent                       = new WhatsappTemplateComponent();
                    $dtComponent->whatsapp_template_id = $template->id;
                    $dtComponent->type                 = $components->type;
                    $dtComponent->text                 = @$components->text;
                    $dtComponent->save();

                    if(@$components->buttons){
                        foreach ($components->buttons as $components) {
                            $comButton = new WhatsappTemplateComponentButton();
                            $comButton->whatsapp_template_component_id = $dtComponent->id;
                            $comButton->type        = $components->type;
                            $comButton->text        = $components->text;
                            $comButton->save();
                            echo $components->type.'<br>';
                            echo $components->text.'<br>';
                        }
                    }

                    if(@$components->example){
                        foreach ($components->example as $examples) {
                            foreach ($examples as $example) {
                                echo $example[0]."<br>";
                                echo $example[1]."<br>";
                                echo @$example[2]."<br>";
                                echo @$example[3]."<br>";
                            }
                        }
                    }
                }

                echo "<br>";
            }
        }
    }
}
