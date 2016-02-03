<?php
session_start();
if (isset($_SESSION['user_id']))
{
    echo '1111';
    session_destroy();
    $home_url = 'http://'.$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']).'index.php';
    header('Location: '.$home_url);
}