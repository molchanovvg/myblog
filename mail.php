<?php
function SendMail($message_body){

    global $config;
    // Create the mail transport configuration
    $transport = Swift_SmtpTransport::newInstance($config->getParam('Server_SMTP'), 465);
    $transport->setUsername($config->getParam('Server_Name'));
    $transport->setPassword($config->getParam('Server_Pass'));
    $transport->setEncryption('ssl');

// Create the message
    $message = Swift_Message::newInstance('-f %s');
    $message->setTo(array(
        $config->getParam('Server_To') => $config->getParam('Server_To_Name')
    ));
    $message->setSubject('Error site myblog');
    $message->setBody($message_body);
    $message->setFrom($config->getParam('Server_From'), "Myblog");

// Send the email
    $mailer = Swift_Mailer::newInstance($transport);
    $mailer->send($message, $failedRecipients);
}



