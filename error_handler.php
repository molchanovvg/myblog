<?php
// функция обработки ошибок
function myErrorHandler($errno, $errstr, $errfile, $errline)
{

    if (!(error_reporting() & $errno)) {
        // Этот код ошибки не включен в error_reporting
        return;
    }

    $subject = "Error at " . $_SERVER['HOSTNAME'];
    $message = "";
    $exit = 0;
    switch ($errno) {
        case E_USER_ERROR:
        case E_ERROR:
        case E_PARSE:
            $message = "<b>My ERROR</b> [$errno] $errstr<br />";
            $message .= "  Фатальная ошибка в строке $errline файла $errfile";
            $message .= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
            $message .= "Завершение работы...<br />\n";
            $exit = -1;
            break;

        case E_USER_WARNING:
        case E_WARNING:
            echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
            break;

        case E_USER_NOTICE:
        case E_NOTICE;
            echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
            break;

        default:
            echo "Неизвестная ошибка: [$errno] $errstr<br />\n";
            break;
    }

    #file_put_contents('error.log', $message, FILE_APPEND | LOCK_EX);
    #error_log($message, 3, 'error.log');

    switch(ENV)
    {
        case 'dev':
            echo $message;
            break;

        case 'test':
            break;

        case 'prod':
            mail('john@connor.ru', $subject, $message);
            #error_log($message, 1, 'john@connor.ru');
            break;
    }

    if($exit)
        exit($exit);
}

if (ENV == 'prod')
{
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
} else {
    error_reporting(E_ALL);
}

set_error_handler("myErrorHandler");
