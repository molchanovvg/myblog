<?php
$PageTitle='Просмотр записи';
require_once('header_t.php');
require_once('connectvars.php');
require_once('connectdb_t.php');
require_once('authss_t.php');
?>
<div id="wrapper">

    <!-- Content -->
    <div id="content">
        <div class="inner">

            <!-- Post -->
            <?php
            if (isset($_GET['id']))
            {
                $id=$_GET['id'];
            }
            else
            {
                exit();
            }
            $dbc = new mysqli (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            mysqli_set_charset($dbc,'utf8');
            if ($dbc -> connect_error)
            {
                die('Error connection Mysql-server ('.$dbc->connect_error.')');
            }
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
            ?>
                <article class="box post post-excerpt">
                    <header>
                        <h2><?php echo html_entity_decode($head) ?></h2>
                    </header>
                    <div class="info">
                        <span class="date"><span class="month">Jul<span>y</span></span> <span class="day">14</span><span class="year">, 2014</span></span>
                    </div>
                    <p><?php echo html_entity_decode($date)?></p>
                    <p><?php echo html_entity_decode($rec) ?></p>
                </article>
            <?php
            };
            mysqli_close($dbc);
            if (isset($_SESSION['user_id']))
            {
                ?>
                <!-- New commit -->
                <p>Добавить комментарий</p>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <label for="commit">Комментарий:</label><br>
                    <textarea name="commit" cols="40" rows="10" id="commit"></textarea><br>
                    <input type="submit" value="Прокомментировать" name="submit">
                </form>
                <?php
                if (isset($_POST['submit']))
                {
                   echo $_POST['commit'] ;
                }
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


