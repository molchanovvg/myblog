<?php


// Подключаем конфигурацию
$params=include('params.php');
if (is_file('params.dev.php'))
{
    $params = array_merge($params, include('params.dev.php'));
}
if (is_file('params.prod.php'))
{
    $params = array_merge($params, include('params.prod.php'));
}

require_once( "Configuration.php" );
$config = new Configuration($params);

// Свой обработчик ошибок
require_once('error_handler.php');

// коннект к БД
require_once('connectdb_t.php');

// библиотека для отправки почты
if (is_file('./vendor/autoload.php'))
    include_once('./vendor/autoload.php');