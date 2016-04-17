<?php
function SendMail($message_body){


    // Create the mail transport configuration
    $transport = Swift_SmtpTransport::newInstance(Server_SMTP, 465);
    $transport->setUsername(Server_Name);
    $transport->setPassword(Server_Pass);
    $transport->setEncryption('ssl');

// Create the message
    $message = Swift_Message::newInstance('-f %s');
    $message->setTo(array(
        Server_To => Server_To_Name
    ));
    $message->setSubject('Error site myblog');
    $message->setBody($message_body);
    $message->setFrom(Server_From, "Myblog");

// Send the email
    $mailer = Swift_Mailer::newInstance($transport);
    $mailer->send($message, $failedRecipients);
}



