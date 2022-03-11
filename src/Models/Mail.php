<?php
namespace App\Models;

use Mailjet\Client;
use Mailjet\Resources;

class Mail 
{
    private $api_key = "54abf7bd7c959b059abdee6778722a2c";
    private $api_key_secret = "89a12b1d1e22e0c08167316926b02e1e";

    public function send(string $emailTo, string $name, string $subject, string $content)
    {
        $mj = new Client($this->api_key, $this->api_key_secret,true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "bonnal.tristan@hotmail.fr",
                        'Name' => "Tristan",
                    ],
                    'To' => [
                        [
                            'Email' => $emailTo,
                            'Name' => $name
                        ]
                    ],
                    'TemplateID' => 3732103,
                    'TemplateLanguage' => true,
                    'CustomID' => "AppGettingStartedTest",
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content,
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        ($response->success()) && dd($response->getData());
    }
}