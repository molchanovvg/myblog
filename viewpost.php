<?php
require_once('connectvars.php');
require_once('connectdb_t.php');
$head='';
if (!isset($_GET['id'])){
    include('404.php');
}
if (isset($_GET['id'])) {
    if ($stmt_select = mysqli_prepare($dbc, "SELECT id, date, head, rec FROM recordtable WHERE id=?")) {
        mysqli_stmt_bind_param($stmt_select, "i", $_GET['id']);
        if (!(mysqli_stmt_execute($stmt_select))) {

            exit ('Ошибка при выборке записей: ' . mysqli_stmt_error($stmt_select));

        };
        mysqli_stmt_bind_result($stmt_select, $id, $date, $head, $rec);
        mysqli_stmt_fetch($stmt_select);
        mysqli_stmt_close($stmt_select);
        if (mysqli_stmt_num_rows($stmt_select) == 0){
            include('404.php');
        }
    }
};



$PageTitle=$head.' просмотр записи в php блоге';
require_once('header_t.php');

session_start();
?>
<div id="wrapper">
    <!-- Content -->
    <div id="content">
        <div class="inner">
            <?php

            if ((isset($_POST['submit'])))
            {
                $commit=trim(strip_tags($_POST['commit']));
                if ($stmt_insert = mysqli_prepare($dbc, "INSERT INTO commenttable(commid, date, postid, userid, comment) VALUES (0, NOW(), ?, ?, ?)"))
                {

                    mysqli_stmt_bind_param($stmt_insert, "sss", $_POST['id'] , $_SESSION['user_id'], $commit);
                    if (!(mysqli_stmt_execute($stmt_insert)))
                    {
                        exit ('Ошибка при добавлении записи: '.mysqli_stmt_error($stmt_insert));
                    };
                    mysqli_stmt_close($stmt_insert);
                };
                echo '<p>Вы добавили комментарий.</p>';
                mysqli_close($dbc);
                $home_url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'viewpost.php?id='.$_POST['id'].'';
                header('Location: '.$home_url);

            }
            if (isset($_GET['id']))
            {
                    ?>
                    <article class="box post post-excerpt">
                        <header>
                            <h2><?php echo $head ?></h2>
                        </header>
                        <div class="info">
                            <span class="date">
                                <span class="month"><?php echo date_create($date)->Format('M') ?></span>
                                <span class="day"><?php echo date_create($date)->Format('d') ?></span>
                                <span class="year"><?php echo date_create($date)->Format('y') ?></span>
                            </span>
                        </div>
                        <p><?php echo $date?></p>
                        <p><?php echo $rec ?></p>
                    </article>
                    <?php

                if ($stmt_select = mysqli_prepare($dbc, "SELECT t1.username, t2.date, t2.comment FROM mybloguser as t1, commenttable as t2 WHERE t2.postid=?  AND t2.userid = t1.userid order by t2.date desc"))
                {
                    mysqli_stmt_bind_param($stmt_select, "i", $_GET['id']);
                    if (!(mysqli_stmt_execute($stmt_select)))
                    {
                        exit ('Ошибка при выборке записей: '.mysqli_stmt_error($stmt_select));
                    };
                    mysqli_stmt_bind_result($stmt_select, $name, $date, $comm);
                    while (mysqli_stmt_fetch($stmt_select))
                    {
                        ?>
                        <article class="box post post-excerpt">
                            <header>
                                <h1><?php echo $name.'  '.$date ?></h1>
                            </header>
                            <p>
                                <?php echo $comm?>
                            </p>
                        </article>
                        <?php
                    };

                    mysqli_stmt_close($stmt_select);

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
                        <input type="hidden" value="<?php echo $_GET['id']?>" name="id">
                    </form>
                    <?php
                }
                else
                {
                    echo 'Авторизуйтесь, чтобы добавлять комментарии!';
                }
                   mysqli_close($dbc);
            };
        ?>

        </div>
    </div>

    <?php
    require_once('sidebar_t.php');
    ?>
</div>
</body>
</html>


