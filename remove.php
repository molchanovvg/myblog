<!DOCTYPE HTML>
<html>
<head>
    <title>Удаление поста</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
    <script src="js/jquery.min.js"></script>
    <script src="js/skel.min.js"></script>
    <script src="js/skel-layers.min.js"></script>
    <script src="js/init.js"></script>
    <noscript>
        <link rel="stylesheet" href="css/skel.css" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/style-desktop.css" />
        <link rel="stylesheet" href="css/style-wide.css" />
    </noscript>
    <!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
</head>

<body>
<a href="index.php">На Главную</a>
<p>Удаление записи</p>
<?php
session_start();
if (!isset($_SESSION['user_id']))
{
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['username']))
    {
        $_SESSION['user_id'] = $_COOKIE['user_id'];
        $_SESSION['username'] = $_COOKIE['username'];
    }
    else
    {

        exit('У вас нет доступа к данной странице.');
    }
}
require_once('connectvars.php');

    if (isset($_GET['id'])&& isset($_GET['head']))
    {
        $id=$_GET['id'];
        $head=$_GET['head'];
    }
    else if (isset($_POST['id'])&& isset($_POST['head']))
        {
            $id=$_POST['id'];
            $head=$_POST['head'];
        }
        else
        {
            echo '<p>Нет данных для удаления.</p>';
        }
    if (isset($_POST['submit']))
    {
        if ($_POST['confirm'] == 'Yes') {
            $dbc = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            if ($dbc->connect_error) {
                die('Error connection Mysql-server (' . $dbc->connect_error . ')');
            }

            $query = "DELETE FROM recordtable WHERE id = $id LIMIT 1";

            if ($stmt_delete = mysqli_prepare($dbc, "DELETE FROM recordtable WHERE id = ? LIMIT 1"))
            {
                mysqli_stmt_bind_param($stmt_delete, "i", $id);
                if (!(mysqli_stmt_execute($stmt_delete)))
                {
                    echo 'Ошибка при удалении записи';
                };
                mysqli_stmt_close($stmt_delete);
            };
            echo '<p>Рейтинг с заголовком ' . $head . ' был удален</p>';
            mysqli_close($dbc);
        }
        else
        {
            echo '<p>Ошибка при удалении</p>';
        }
    }
    else if (isset($id)&& isset($head))
    {
        echo '<p>Вы уверены что хотите удалить?</p>';
        echo '<br>';
        echo '<p>'.$head.'</p>';
        echo '<form method="post" action="remove.php">';
        echo '<input type="radio" name="confirm" value="Yes" /> Yes';
        echo '<input type="radio" name="confirm" value="no" checked="checked" /> No <br>';
        echo '<input type="submit" value="submit" name="submit"/>';
        echo '<input type="hidden" name="id" value="'.$id.'"/>';
        echo '<input type="hidden" name="head" value="'.$head.'"/>';
        echo '</form>';
    }






?>
</body>
</html>