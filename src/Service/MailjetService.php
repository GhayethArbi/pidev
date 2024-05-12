<?php

namespace App\Service;

use Mailjet\Client;
use Mailjet\Resources;

class MailjetService
{
    private $apiKey="9a8b5623b8898aee373c3df7eebebdba" ;  // Your MailJet API Key here
    private $secretKey="2ad0265e5e5f902cdecedf294c8a2f55";    // Your MailJet Secret Key here
    public function sendMail( $content,$toEmail,$toName):void
    {
        $mj= new Client($this->apiKey,$this->secretKey,true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "chouchene.moeetez@esprit.tn",
                        'Name' => "cbnnnnnnn"
                    ],
                    'To' => [
                        [
                            'Email' => $toEmail,
                            'Name' => $toName,
                        ]
                    ],
                    'TemplateID' => 5755528,
                    'TemplateLanguage' => true,
                    'Variables' => [
 
                        "content" => $content,
 
 
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
       
    }
    
}

?>