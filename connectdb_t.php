<?php
$dbc = new mysqli(
    $config->getParam('DB_HOST'),
    $config->getParam('DB_USER'),
    $config->getParam('DB_PASSWORD'),
    $config->getParam('DB_NAME')
);

mysqli_set_charset($dbc, "utf8");
if ($dbc -> connect_error)
{
    die('Error connection Mysql-server ('.$dbc->connect_error.')');
}
?>

