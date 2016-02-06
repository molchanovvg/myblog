<?php
$PageTitle='Удаление поста';
require_once('header_t.php');
require_once('connectvars.php');
require_once('connectdb_t.php');
session_start();

    if (isset($_SESSION)&& $_SESSION['right'] != 1)
    {
        exit('У вас нет доступа к данной странице.');
    }
?>
<div id="wrapper">
            <!-- Content -->
                    <div id="content">
                        <div class="inner">
                            <?php
                                if (isset($_POST['submit']))
                                {
                                    echo $_POST['id'];
                                    if ($_POST['confirm'] == 'Yes')
                                    {
                                        if ($stmt_delete = mysqli_prepare($dbc, "DELETE FROM recordtable WHERE id = ? LIMIT 1"))
                                        {
                                            mysqli_stmt_bind_param($stmt_delete, "i", $_POST['id']);
                                            if (!(mysqli_stmt_execute($stmt_delete)))
                                            {
                                                echo 'Ошибка при удалении записи';
                                            };
                                            mysqli_stmt_close($stmt_delete);
                                        };
                                        echo '<p>Запись блога удалена</p>';
                                        mysqli_close($dbc);
                                        $home_url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'manage.php';
                                        header('Location: '.$home_url);
                                    }
                                    else
                                    {
                                        if ($_POST['confirm']=='No')
                                        {
                                            $home_url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'viewpost.php?id='.$_POST['id'];
                                            header('Location: '.$home_url);
                                        }

                                    }
                                }
                                else if (isset($_GET['id']))
                                {
                                    ?>
                                    <p>Вы уверены что хотите удалить?</p>
                                    <br>
                                    <form method="post" action="remove.php">
                                        <input type="radio" name="confirm" value="Yes" /> Yes
                                        <input type="radio" name="confirm" value="No" checked="checked" /> No <br>
                                        <input type="submit" value="submit" name="submit"/>
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>"/>
                                    </form>
                                    <?php
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