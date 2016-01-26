<!DOCTYPE HTML>
<html>
<head>
    <title>Добавление поста</title>
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

                            <!-- Post -->
                            <?php
                                if (isset($_POST['submit']))
                                {
                                    $header=trim($_POST['header']);
                                    $record=trim($_POST['record']);

                                    if (!empty($header)&& !empty($record))
                                    {
                                        //connect db
                                        $dbc = new mysqli(DB_HOST,DB_USER, DB_PASSWORD, DB_NAME);
                                        $header=htmlentities(mysqli_real_escape_string($dbc,$header));
                                        $record=htmlentities(mysqli_real_escape_string($dbc,$record));
                                        mysqli_set_charset($dbc, "utf8");
                                        if ($stmt_insert = mysqli_prepare($dbc, "INSERT INTO recordtable VALUES (0, NOW(), ?, ?)"))
                                        {
                                            mysqli_stmt_bind_param($stmt_insert, "ss", $header, $record);
                                            if (!(mysqli_stmt_execute($stmt_insert)))
                                            {
                                                echo 'Ошибка при добавлении записи';
                                            };
                                            mysqli_stmt_close($stmt_insert);
                                        };
                                        echo '<p>Вы добавили запись.</p>';
                                        $header="";
                                        $record="";
                                        mysqli_close($dbc);
                                    }
                                    else
                                    {
                                        echo '<p>Чего-то не хватает :(.</p>';
                                    }
                                }
                                ?>
                                <p>Добавление новой записи в блог</p>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <label for="header">Заголовок:</label><br>
                                    <input type="text" name="header" id="header"><br>
                                    <label for="record">Текст:</label><br>
                                    <textarea name="record" cols="80" rows="20" id="record"></textarea><br>
                                    <input type="submit" value="Поделиться" name="submit">
                                </form>




</div>
</div>
        <?php
        require_once('sidebar_t.php');
        ?>
    </div>
</body>
</html>