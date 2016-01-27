<?php
    $PageName='Вход в приложение';
    require_once('header_t.php');
session_start();
require_once('connectvars.php');
$error_msg="";
?>


<div id="wrapper">

    <!-- Content -->
    <div id="content">
        <div class="inner">
                        <?php


                        if (!isset($_SESSION['user_id'])) {
                            if (isset($_POST['submit']))
                            {
                                $dbc = new mysqli (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                                if ($dbc -> connect_error)
                                {
                                    die('Error connection Mysql-server ('.$dbc->connect_error.')');
                                }
                                $user_username=mysqli_real_escape_string($dbc, trim($_POST['username']));
                                $user_password=mysqli_real_escape_string($dbc, trim($_POST['password']));

                                if (!empty($user_username) && !empty($user_password))
                                {
                                    if ($stmt_select = mysqli_prepare($dbc, "SELECT userid, username, userright FROM mybloguser WHERE username=? AND password=SHA(?)"))
                                    {
                                        mysqli_stmt_bind_param($stmt_select, "ss", $user_username, $user_password);
                                        if (!(mysqli_stmt_execute($stmt_select)))
                                        {
                                            echo 'Ошибка при выборке данных';
                                        }
                                        mysqli_stmt_store_result($stmt_select);
                                        mysqli_stmt_bind_result($stmt_select, $id, $name, $userright);
                                        mysqli_stmt_fetch($stmt_select);





                                        if (mysqli_stmt_num_rows($stmt_select)==1)
                                        {
                                            $_SESSION['user_id']=$id;
                                            $_SESSION['username']=$name;
                                            $_SESSION['right']=$userright;
                                            setcookie('user_id', $id, time() + (60*60*24*30));
                                            setcookie('username', $name, time() + (60*60*24*30));
                                            setcookie('right', $userright, time() + (60*60*24*30));
                                            $home_url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'index.php';
                                            header('Refresh: 2; url='.$home_url);
                                            echo '<p>Вы вошли как '.$user_username.'</p>';

                                        }
                                        else
                                        {

                                            $error_msg='Нет такого пользователя или неправильно введен пароль.';
                                        }
                                        mysqli_stmt_close($stmt_select);
                                        mysqli_close($dbc);
                                    }
                                }
                                else
                                {
                                    $error_msg='Необходимо ввести пароль, чтобы войти';
                                }
                            }
                        }






                         if (empty($_COOKIE['user_id']))
                         {
                             echo $error_msg;

                        ?>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <fieldset>
                                <legend>Вход в блог</legend>
                                <label for="username">Имя пользователя:</label>
                                <input type="text" name="username" value="<?php if (!empty($user_username)) echo $user_username; ?>"/><br/>
                                <label for="password">Пароль:</label>
                                <input type="password" name="password"/><br/>
                            </fieldset>
                            <input type="submit" value="Войти" name="submit"/>
                        </form>
                        <?php
                        }
                        else
                        {
                            echo ('<p>Вы вошли в приложение как '.$_COOKIE['username'].'.</p>');
                            $home_url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'index.php';
                            header('Refresh: 2; url='.$home_url);
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