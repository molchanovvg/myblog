<?php
$PageTitle='Управление';
require_once('header_t.php');
require_once('connectvars.php');
require_once('connectdb_t.php');

if (isset($_SESSION) && $_SESSION['right'] != 1)
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

                                    // проверка на наличие такой записи add
                                    if ($stmt_select = mysqli_prepare($dbc, "SELECT id, date, head, rec FROM recordtable WHERE id=? ")) {
                                        mysqli_stmt_bind_param($stmt_select, "i", $_POST['id']);
                                        if (!(mysqli_stmt_execute($stmt_select)))
                                        {
                                            exit ('Ошибка при выборке записей: '.mysqli_stmt_error($stmt_select));
                                        }
                                        mysqli_stmt_store_result($stmt_select);
                                        mysqli_stmt_bind_result($stmt_select, $id, $date, $head_, $rec_);
                                        mysqli_stmt_fetch($stmt_select);

                                        $head = trim(strip_tags($_POST['header']));
                                        $rec = trim(strip_tags($_POST['record']));

                                        if (mysqli_stmt_num_rows($stmt_select) == 1) {
                                            if ($stmt_update = mysqli_prepare($dbc, "UPDATE recordtable SET head = ?, rec= ? WHERE id = ? ")) {
                                                mysqli_stmt_bind_param($stmt_update, "ssi", $head, $rec, $_POST['id']);
                                                if (!(mysqli_stmt_execute($stmt_update)))
                                                {
                                                    exit ('Ошибка при изменении записей: '.mysqli_stmt_error($stmt_update));
                                                };
                                                mysqli_stmt_close($stmt_update);
                                            };
                                            mysqli_close($dbc);
                                            echo '<p>Статья с заголовком ' . $head . ' была изменена</p>';
                                            echo '<a href="/viewpost.php?id=' . $_POST['id'] . '"">Просмотреть статью</a></br>';
                                            echo '<a href="/edit.php?id=' . $_POST['id'] . '"">Продолжить редактирование</a>';

                                        } else {
                                            $error_msg = 'Такой записи не существует.';
                                        }
                                        mysqli_stmt_close($stmt_select);
                                        mysqli_close($dbc);
                                    }
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
                                    if ($stmt_select = mysqli_prepare($dbc, "select id, date, head, rec from recordtable WHERE id=?"))
                                    {
                                        mysqli_stmt_bind_param($stmt_select, "i", $id);
                                        if (!(mysqli_stmt_execute($stmt_select)))
                                        {
                                            exit ('Ошибка при выборке записей: '.mysqli_stmt_error($stmt_select));
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