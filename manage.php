<!DOCTYPE HTML>
<html>
<head>
    <title>Управление</title>
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

<body class="left-sidebar">
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
?>

<div id="wrapper">

    <!-- Content -->
    <div id="content">
        <div class="inner">
            <?php
            if ((isset($_SESSION['user_id'])) && ($_SESSION['right']==1))
            {
                ?>
                <p>Здесь можно отредактировать или удалить записи MyBlog</p>
                <?php
                $dbc = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                if ($dbc->connect_error) {
                    die('Error connecting Mysql server (' . $dbc->connect_error . ')');
                }
                $query = 'SELECT * FROM recordtable ORDER BY date DESC';
                mysqli_set_charset($dbc, 'utf8');
                if ($result = $dbc->query($query)) {
                    while ($row = mysqli_fetch_array($result)) {
                        echo $row['date'] . '  ' . $row['head'] . '  ';
                        echo '<a href=edit.php?id=' . $row['id'] . '&amp;head=' . $row['head'] . '>Редактировать</a>';
                        echo '<a href=remove.php?id=' . $row['id'] . '&amp;head=' . $row['head'] . '>Удалить</a>';
                        echo '<br>';
                    }
                }
                mysqli_close($dbc);
            }
            else
            {
             echo '<p>У вас нет доступа</p>';
            }
            ?>
        </div>
    </div>

<?php
require_once('sidebar_t.php');
?>
</div>

</body>
</html>