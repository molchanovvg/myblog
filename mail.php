<?php
function SendMail($message_body){
    // Create the mail transport configuration
    $transport = Swift_SmtpTransport::newInstance("smtp.yandex.ru", 465);
    $transport->setUsername("molchanov256@yandex.ru");
    $transport->setPassword("356893005542996");
    $transport->setEncryption('ssl');

// Create the message
    $message = Swift_Message::newInstance('-f %s');
    $message->setTo(array(
        "valeruko@gmail.com" => "valeruko"
    ));
    $message->setSubject('Error site myblog');
    $message->setBody($message_body);
    $message->setFrom("molchanov256@yandex.ru", "Myblog");

// Send the email
    $mailer = Swift_Mailer::newInstance($transport);
    $mailer->send($message, $failedRecipients);
}



