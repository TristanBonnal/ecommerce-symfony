<?php
namespace App\Service;

use Mailjet\Client;
use Mailjet\Resources;

class Mail 
{
    private $api_key = "54abf7bd7c959b059abdee6778722a2c";
    private $api_key_secret = "89a12b1d1e22e0c08167316926b02e1e";

    public function send($toEmail, $toName, $subject, $content)
    {
        $mj = new Client($this->api_key, $this->api_key_secret,true,['version' => 'v3.1']);
        $body = 
        [
            'Messages' => 
            [
                [
                    'From' => 
                    [
                        'Email' => "bonnal.tristan@hotmail.fr",
                        'Name' => "La Boot'ique"
                    ],
                    'To' => 
                    [
                        [
                            'Email' => $toEmail,
                            'Name' => $toName
                        ]
                    ],
                    'TemplateID' => 3732103,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => ['content' => $content]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
    }
}