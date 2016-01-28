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


            <?php
            if (!(isset($_GET['id'])) && (isset($_POST['submit'])))
            {
                $commit=strip_tags($commit);
                $commit=htmlentities(mysqli_real_escape_string($dbc,$_POST['commit']));
                if ($stmt_insert = mysqli_prepare($dbc, "INSERT INTO commenttable VALUES (0, NOW(), ?, ?, ?)"))
                {
                    mysqli_stmt_bind_param($stmt_insert, "sss",$_SESSION['postid'] , $_SESSION['user_id'], $commit);
                    if (!(mysqli_stmt_execute($stmt_insert)))
                    {
                        echo 'Ошибка при добавлении записи';
                    };
                    mysqli_stmt_close($stmt_insert);
                };
                echo '<p>Вы добавили запись.</p>';

                mysqli_close($dbc);
                unset($_SESSION['postid']);
                $home_url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'viewpost.php?id='.$_SESSION['postid'].'';
                header('Refresh: 1; url='.$home_url);

            }
            if (isset($_GET['id']))
            {
                $_SESSION['postid']=$_GET['id'];
                if ($stmt_select = mysqli_prepare($dbc, "select * from recordtable WHERE id=?"))
                {
                    mysqli_stmt_bind_param($stmt_select, "i", $_GET['id']);
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
                }
                if ($stmt_select = mysqli_prepare($dbc, "SELECT t1.username, t2.date, t2.comment FROM mybloguser as t1, commenttable as t2 WHERE t2.postid=?  AND t2.userid = t1.userid"))
                {
                    mysqli_stmt_bind_param($stmt_select, "i", $_GET['id']);
                    if (!(mysqli_stmt_execute($stmt_select)))
                    {
                        echo 'Ошибка при выборе записи';
                    };
                    mysqli_stmt_bind_result($stmt_select, $name, $date, $comm);
                    while (mysqli_stmt_fetch($stmt_select))
                    {
                        ?>
                                        <article class="box post post-excerpt">
                                            <header>
                                                <h1><?php echo html_entity_decode($name).'  '.$date ?></h1>
                                            </header>
                                            <p>
                                                <?php echo html_entity_decode($comm) ?>
                                            </p>
                                        </article>
                        <?php
                    };

                    mysqli_stmt_close($stmt_select);

                };

                   mysqli_close($dbc);
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


