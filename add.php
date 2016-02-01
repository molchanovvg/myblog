<?php
$PageTitle='Добавление поста';
require_once('header_t.php');
require_once('connectvars.php');
require_once('connectdb_t.php');
require_once('authss_t.php');

if ($_SESSION['right'] != 1)
{
    exit('У вас нет доступа к данной странице.');
}


?>
    <div id="wrapper">

            <!-- Content -->
                    <div id="content">
                        <div class="inner">

                            <!-- Post -->
                            <?php
                                if (isset($_POST['submit']))
                                {
                                    $header=strip_tags(trim($_POST['header']));
                                    $record=strip_tags(trim($_POST['record']));

                                    if (!empty($header)&& !empty($record))
                                    {
                                        $header=mysqli_real_escape_string($dbc,$header);
                                        $record=mysqli_real_escape_string($dbc,$record);
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