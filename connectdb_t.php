<?php
$dbc = new mysqli (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_set_charset($dbc, "utf8");
if ($dbc -> connect_error)
{
    die('Error connection Mysql-server ('.$dbc->connect_error.')');
}
?>