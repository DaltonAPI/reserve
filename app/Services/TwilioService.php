<?php

// TwilioService.php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    public function sendSMS($customerPhoneNumber, $customerName, $reservationDate, $reservationTime)
    {
        $twilioSid = env('TWILIO_SID');
        $twilioAuthToken = env('TWILIO_AUTH_TOKEN');
        $twilioPhoneNumber = env('TWILIO_PHONE_NUMBER');

        $client = new Client($twilioSid, $twilioAuthToken);
        $messageBody = 'Hello ' . $customerName . ', You have an appointment on Date: ' . $reservationDate . '@ Time: ' . $reservationTime;

        $client->messages->create(
            $customerPhoneNumber,
            [
                'from' => $twilioPhoneNumber,
                'body' => $messageBody
            ]
        );
    }
}
