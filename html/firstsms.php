<?php
// Update the path below to your autoload.php,
// see https://getcomposer.org/doc/01-basic-usage.md
require_once '/path/to/vendor/autoload.php';

use Twilio\Rest\Client;

// Your Account Sid and Auth Token from twilio.com/console
$sid    = "AC7d21a2c654275c93b8cb9a3d169521af";
$token  = "your_auth_token";
$twilio = new Client($sid, $token);

$message = $twilio->messages
                  ->create("whatsapp:+917680967302",
                           array(
                               "body" => "Hello there!",
                               "from" => "whatsapp:+918498812792"
                           )
                  );

print($message->sid);?>
