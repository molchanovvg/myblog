<?php
$PageName='Страница регистрации';
require_once('header_t.php');
require_once('connectvars.php');
require_once('connectdb_t.php');
$form_visible=true;
?>
<div id="wrapper">

            <!-- Content -->
                    <div id="content">
                        <div class="inner">
                            <?php
                                //$dbc = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                                if (isset($_POST['submit']))
                                {
                                    $username=strip_tags(mysqli_real_escape_string($dbc, trim($_POST['username'])));
                                    $password1=strip_tags(mysqli_real_escape_string($dbc, trim($_POST['password1'])));
                                    $password2=strip_tags(mysqli_real_escape_string($dbc, trim($_POST['password2'])));
                                    if (!empty($username) && !empty($password1) && !empty($password2) && $password1==$password2)
                                    {
                                        // проверка нет ли уже такого пользователя
                                        if ($stmt_select = mysqli_prepare($dbc, "select * from mybloguser WHERE username=?"))
                                        {
                                            mysqli_stmt_bind_param($stmt_select, "s", $username);
                                            if (!(mysqli_stmt_execute($stmt_select)))
                                            {
                                                echo 'Ошибка при выборе записи';
                                            };
                                            mysqli_stmt_bind_result($stmt_select, $userid, $username_sel, $password_sel);
                                            mysqli_stmt_fetch($stmt_select);
                                            mysqli_stmt_close($stmt_select);
                                            if (empty($username_sel))
                                            {
                                                if ($stmt_update = mysqli_prepare($dbc, "INSERT INTO mybloguser VALUES (0, ?, SHA(?),0)"))
                                                {
                                                    mysqli_stmt_bind_param($stmt_update, "ss", $username, $password1);
                                                    if (!(mysqli_stmt_execute($stmt_update)))
                                                    {
                                                        echo 'Ошибка при изменении записи';
                                                    }
                                                    else
                                                    {
                                                        echo '<p>Ваша учетная запись создана. Вы можете <a href="login.php">войти</a> в приложение.</p>';
                                                        $form_visible=false;

                                                    }
                                                    mysqli_stmt_close($stmt_update);
                                                    mysqli_close($dbc);
                                                };
                                            }
                                            else
                                            {
                                                echo '<p>Такой пользователь уже есть, введите другое имя.</p>';
                                                $username="";
                                            }
                                        }
                                    }
                                    else
                                    {
                                        echo '<p>Проверьте введеные данные</p>';
                                    }
                                }
                                if ($form_visible)
                                {
                                    ?>

                                    <form method="post" action="<?php echo $_SERVER['php_self']; ?>">
                                        <fieldset>
                                            <legend>Введите имя и пароль для создания учетной записи</legend>
                                            <label for="username">Имя пользователя:</label>
                                            <input type="text" name="username" id="username"
                                                   value="<?php if (!empty($username)) echo $username; ?>"/><br/>
                                            <label for="password1">Пароль:</label>
                                            <input type="password" name="password1" id="password1"/><br/>
                                            <label for="password2">Подтверждение Пароля:</label>
                                            <input type="password" name="password2" id="password2"/><br/>
                                        </fieldset>
                                        <input type="submit" value="Создать" name="submit">
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