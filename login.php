<?php
    require_once('core.php');
    $PageTitle='Вход в блог';
    require_once('header_t.php');
    session_set_cookie_params(30*24*60*60, '/', '.myblog', false,true);
    session_start();
    $error_msg="";
?>

<div id="wrapper">

    <!-- Content -->
    <div id="content">
        <div class="inner">
                        <?php
                        if (!isset($_SESSION['user_id']))
                        {
                            if (isset($_POST['submit']))
                            {
                                $user_username=trim(strip_tags($_POST['username']));
                                $user_password=trim(strip_tags($_POST['password']));
                                if (!empty($user_username) && !empty($user_password))
                                {
                                    if ($stmt_select = mysqli_prepare($dbc, "SELECT userid, username, userright FROM mybloguser WHERE username=? AND password=SHA(?)"))
                                    {
                                        mysqli_stmt_bind_param($stmt_select, "ss", $user_username, $user_password);
                                        if (!(mysqli_stmt_execute($stmt_select)))
                                        {
                                            exit ('Ошибка при выборке записей: '.mysqli_stmt_error($stmt_select));
                                        }
                                        mysqli_stmt_store_result($stmt_select);
                                        mysqli_stmt_bind_result($stmt_select, $id, $name, $userright);
                                        mysqli_stmt_fetch($stmt_select);

                                        if (mysqli_stmt_num_rows($stmt_select)==1)
                                        {
                                            $_SESSION['user_id']=$id;
                                            $_SESSION['username']=$name;
                                            $_SESSION['right']=$userright;
                                            $_SESSION['ua']=$_SERVER['HTTP_USER_AGENT'];
                                            $home_url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'index.php';
                                            header('Location: '.$home_url);
                                        }
                                        else
                                        {
                                            trigger_error('Нет такого пользователя или неправильно введен пароль.', E_USER_WARNING);
                                        }
                                        mysqli_stmt_close($stmt_select);
                                        mysqli_close($dbc);
                                    }
                                    else
                                    {
                                            echo mysqli_error($dbc);
                                    }
                                }
                                else
                                {
                                    trigger_error('Необходимо ввести пароль, чтобы войти.', E_USER_NOTICE);
                                }
                            }
                            if (!isset($_POST['submit']) || !empty($error_msg))
                            {
                                ?>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <fieldset>
                                        <legend>Вход в блог</legend>
                                        <label for="username">Имя пользователя:
                                            <input type="text" name="username" value="<?php if (!empty($user_username)) echo $user_username; ?>"/>
                                        </label>
                                        <label for="password">Пароль:
                                            <input type="password" name="password"/>
                                        </label>
                                    </fieldset>
                                    <br>
                                    <input type="submit" value="Войти" name="submit"/>
                                </form>
                                <?php
                            }
                        }

                        else
                        {
                            $home_url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'index.php';
                            header('Location: '.$home_url);
                        }
                        /*echo $error_msg;*/
                        ?>
        </div>
    </div>

<?php require_once('sidebar_t.php'); ?>
</div>
</body>
</html>