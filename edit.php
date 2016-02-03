<?php
$PageTitle='Управление';
require_once('header_t.php');
require_once('connectvars.php');
require_once('connectdb_t.php');
require_once('authss_t.php');

if (!isset($_SESSION) || $_SESSION['right'] != 1)
{
    exit('У вас нет доступа к данной странице.');
}


?>

<div id="wrapper">

            <!-- Content -->
                    <div id="content">
                        <div class="inner">
                            <?php
                                if (isset($_POST['submit']) && (!empty($_POST['header'])&& !empty($_POST['record'])))
                                {
                                    $dbc = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                                    mysqli_set_charset($dbc, "utf8");
                                    if ($dbc->connect_error)
                                    {
                                        die('Error connection Mysql-server ('.$dbc->connect_error.')');
                                    }
                                    $head=mysqli_real_escape_string($dbc, strip_tags(trim($_POST['header'])));
                                    $rec=mysqli_real_escape_string($dbc, strip_tags(trim($_POST['record'])));
                                    // проверка на наличие такой записи add
                                    if ($stmt_update = mysqli_prepare($dbc, "UPDATE recordtable SET head = ?, rec= ? WHERE id = ? "))
                                    {
                                        mysqli_stmt_bind_param($stmt_update, "ssi", $head, $rec, $_POST['id']);
                                        if (!(mysqli_stmt_execute($stmt_update)))
                                        {
                                            echo 'Ошибка при изменении записи';
                                        };
                                        mysqli_stmt_close($stmt_update);
                                    };
                                    mysqli_close($dbc);
                                    echo '<p>Статья с заголовком ' . $head . ' была изменена</p>';
                                    echo '<a href="/viewpost.php?id=' . $_POST['id'] . '"">Просмотреть статью</a></br>';
                                    echo '<a href="/edit.php?id=' . $_POST['id'] . '"">Продолжить редактирование</a>';
                                }
                                else
                                {
                                    if (isset($_POST['submit']) && (empty($_POST['header'])))
                                    {
                                        echo 'Пустой заголовок поста не разрешается!<br>';
                                    }
                                    if (isset($_POST['submit']) && (empty($_POST['record'])))
                                    {
                                        echo 'Пустой пост не разрешается!';
                                    }
                                    if (isset($_GET['id']))
                                    {
                                        $id=$_GET['id'];
                                    }
                                    if (isset($_POST['id']))
                                    {
                                        $id=$_POST['id'];
                                    }
                                    $dbc = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                                    mysqli_set_charset($dbc, "utf8");
                                    if ($stmt_select = mysqli_prepare($dbc, "select * from recordtable WHERE id=?"))
                                    {
                                        mysqli_stmt_bind_param($stmt_select, "i", $id);
                                        if (!(mysqli_stmt_execute($stmt_select)))
                                        {
                                            echo 'Ошибка при выборе записи';
                                        };
                                        mysqli_stmt_bind_result($stmt_select, $id, $date, $head, $rec);
                                        mysqli_stmt_fetch($stmt_select);
                                        mysqli_stmt_close($stmt_select);
                                    };
                                    mysqli_close($dbc);
                                    ?>
                                    <form method="post" action="edit.php">
                                        <label for="header">Заголовок:</label><br>
                                        <input type="text" name="header" id="header" value="<?php echo $head ?>"><br>
                                        <label for="record">Текст:</label><br>
                                        <textarea name="record" cols="80" rows="20" id="record"><?php echo $rec ?></textarea><br>
                                        <input type="hidden" name="id" value="<?php echo $id ?>"/>
                                        <input type="submit" value="submit" name="submit">
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