<?php
// функция обработки ошибок
function myErrorHandler($errno, $errstr, $errfile, $errline, $config)
{
    global $config;
    if (!(error_reporting() & $errno)) {
        // Этот код ошибки не включен в error_reporting
        echo 'Something went wrong';
        return;
    }
    $message='';
    $exit=0;
    switch ($errno) {
        case E_USER_ERROR:
            $message = "My ERROR: [$errno] $errstr \n";
            $message .= "  Фатальная ошибка в строке $errline файла $errfile";
            $message .= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
            $message .= "Завершение работы...<br />\n";
            $exit=-1;
            break;

        case E_USER_WARNING:
            $message = "My ERROR: [$errno] $errstr \n";
            break;

        case E_USER_NOTICE:
            $message = "My ERROR: [$errno] $errstr \n";
            break;
        case E_WARNING:
            $message = "My ERROR: [$errno] $errstr \n";
            break;

        default:
            $message = "Неизвестная ошибка: [$errno] $errstr\n";
            break;
    }

    file_put_contents('error.log',$message, FILE_APPEND | LOCK_EX);

    switch ($config->getParam('ENV')){
        case 'dev':
            echo $message;
            break;
        case 'prod':
            require_once('mail.php');
            SendMail($message);
            break;
        default:

            break;

    }
    if ($exit)
        exit($exit);
}

set_error_handler("myErrorHandler");