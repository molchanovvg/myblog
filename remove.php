<?php
$PageTitle='Удаление поста';
require_once('header_t.php');
require_once('connectvars.php');
require_once('connectdb_t.php');
session_start();

if (!isset($_SESSION, $_SESSION['right'], $_SESSION['ua']) || $_SESSION['right'] != 1 || $_SESSION['ua']!=$_SERVER['HTTP_USER_AGENT'])
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
                                    if ($_POST['confirm'] == 'Yes')
                                    {
                                        if ($stmt_delete = mysqli_prepare($dbc, "DELETE FROM recordtable WHERE id = ? LIMIT 1"))
                                        {
                                            mysqli_stmt_bind_param($stmt_delete, "i", $_POST['id']);
                                            if (!(mysqli_stmt_execute($stmt_delete)))
                                            {
                                                exit ('Ошибка при удалении записи: '.mysqli_stmt_error($stmt_delete));
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
                                    if ($stmt_select = mysqli_prepare($dbc, "SELECT head FROM recordtable WHERE id=?"))
                                    {
                                        mysqli_stmt_bind_param($stmt_select,"i", $_GET['id']);
                                        if (!(mysqli_stmt_execute($stmt_select)))
                                        {
                                            exit ('Ошибка при выборке записей: '.mysqli_stmt_error($stmt_select));
                                        }
                                        mysqli_stmt_store_result($stmt_select);
                                        mysqli_stmt_bind_result($stmt_select, $head);
                                        mysqli_stmt_fetch($stmt_select);
                                    }

                                    ?>
                                    <p>Вы уверены что хотите удалить запись "<?php echo $head;?>" ?</p>
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