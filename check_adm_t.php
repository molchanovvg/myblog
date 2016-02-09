<?php
session_start();
if (!isset($_SESSION, $_SESSION['right'], $_SESSION['ua']) || $_SESSION['right'] != 1 || $_SESSION['ua']!=$_SERVER['HTTP_USER_AGENT'])
{
    exit('У вас нет доступа к данной странице.');
}