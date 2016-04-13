<?php
require_once('core.php');
$head='';
$recordId = isset($_GET['id']) // record id from URL or post data
    ? $_GET['id']
    : isset($_POST['id'])
        ? $_POST['id']
        : null;

if (empty($recordId)){
    include('404.php');
} else {
    if ($stmt_select = mysqli_prepare($dbc, "SELECT id, date, head, rec FROM recordtable WHERE id=?")) {
        mysqli_stmt_bind_param($stmt_select, "i", $recordId);
        if (!(mysqli_stmt_execute($stmt_select))) {
            trigger_error(mysqli_stmt_error($stmt_select), E_USER_WARNING);
            exit ('Ошибка при выборке записей: ' . mysqli_stmt_error($stmt_select));
        };
        mysqli_stmt_store_result($stmt_select);
        mysqli_stmt_bind_result($stmt_select, $id, $date, $head, $rec);
        mysqli_stmt_fetch($stmt_select);
        if (mysqli_stmt_num_rows($stmt_select) == 0){
            mysqli_stmt_close($stmt_select);
            include('404.php');
        }
        mysqli_stmt_close($stmt_select);
    }
};



$PageTitle=$head.' просмотр записи в php блоге';
require_once('header_t.php');

session_start();

$errors = array(); // form processing error messages
?>
<div id="wrapper">
    <!-- Content -->
    <div id="content">
        <div class="inner">
            <?php

            if ((isset($_POST['submit'])))
            {
                if ($_SESSION['pass']==sha1($_POST['verify'])) // check captcha
                {
                    $errors['verify'] = 'Captcha введена не верно!';
                }

                $commit=trim(strip_tags($_POST['commit']));
                if (strlen($commit)<20)
                {
                    $errors['commit'] = 'Текст комментария должен быть не менее 20 символов';
                }

                if (empty($errors))
                {
                    if ($stmt_insert = mysqli_prepare($dbc, "INSERT INTO commenttable(commid, date, postid, userid, comment) VALUES (0, NOW(), ?, ?, ?)"))
                    {

                        mysqli_stmt_bind_param($stmt_insert, "sss", $recordId , $_SESSION['user_id'], $commit);
                        if (!(mysqli_stmt_execute($stmt_insert)))
                        {
                            trigger_error(mysqli_stmt_error($stmt_insert), E_USER_WARNING);
                            $errors['_form'] = 'Ошибка при добавлении комментария';
                        }
                        mysqli_stmt_close($stmt_insert);
                    }

                    mysqli_close($dbc);
                    echo '<p>Вы добавили комментарий.</p>';
                    $home_url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'viewpost.php?id='.$recordId.'';
                    header('Location: '.$home_url);
                }

            }
            if ($recordId)
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
                    mysqli_stmt_bind_param($stmt_select, "i", $recordId);
                    if (!(mysqli_stmt_execute($stmt_select)))
                    {
                        trigger_error(mysqli_stmt_error($stmt_select), E_USER_WARNING);
                        ?><div class="error">Комментарии не найдены</div><?php
                    } else
                    {
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
                    }
                };
                if (isset($_SESSION['user_id']))
                {
                    if (!empty($errors['_form'])) { ?>
                        <div class="error"><?php echo $errors['_form'] ?></div>
                    <?php } ?>
                    <!-- New commit -->
                    <p>Добавить комментарий</p>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <label for="commit">Комментарий:</label><br>
                        <textarea name="commit" cols="40" rows="10" id="commit"><?php echo isset($_POST['commit']) ? htmlentities($_POST['commit']) : '' ?></textarea><br>
                        <?php if (!empty($errors['commit'])) { ?>
                            <div class="error"><?php echo $errors['commit'] ?></div>
                        <?php } ?>
                        <label for="verify">Защита от роботов:</label><br>
                        <img src="captcha.php"><br>
                        <input type="text" name="verify" placeholder="Введите буквы с картинки"><br>
                        <?php if (!empty($errors['verify'])) { ?>
                            <div class="error"><?php echo $errors['verify'] ?></div>
                        <?php } ?>
                        <input type="submit" value="Прокомментировать" name="submit">
                        <input type="hidden" value="<?php echo $recordId ?>" name="id">
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


