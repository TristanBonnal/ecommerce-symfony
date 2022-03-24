<?php
namespace App\Service;

use Mailjet\Client;
use Mailjet\Resources;

class Mail 
{
    private $api_key = "54abf7bd7c959b059abdee6778722a2c";
    private $api_key_secret = "89a12b1d1e22e0c08167316926b02e1e";

    public function send()
    {
        $mj = new Client($this->api_key, $this->api_key_secret,true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
              [
                'From' => [
                  'Email' => "bonnal.tristan@hotmail.fr",
                  'Name' => "Tristan"
                ],
                'To' => [
                  [
                    'Email' => "bonnal.tristan@hotmail.fr",
                    'Name' => "Tristan"
                  ]
                ],
                'Subject' => "Greetings from Mailjet.",
                'TextPart' => "My first Mailjet email",
                'HTMLPart' => "<h3>Dear passenger 1, welcome to <a href='https://www.mailjet.com/'>Mailjet</a>!</h3><br />May the delivery force be with you!",
                'CustomID' => "AppGettingStartedTest"
              ]
            ]
          ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        ($response->success()) && dump($response->getData());
    }
}