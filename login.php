<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title>Edit Page</title>
</head>
<body>
<a href="index.php">На Главную</a>
<?php
require_once('connectvars.php');

if (!isset($_SERVER['PHP_AUTH_USER'])||!isset($_SERVER['PHP_AUTH_PW']))
{
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="MyBlog"');
    exit('Необходимо ввести пароль, чтобы войти');
}
$dbc = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$user_username=mysqli_real_escape_string($dbc, trim($_SERVER['PHP_AUTH_USER']));
$user_password=mysqli_real_escape_string($dbc, trim($_SERVER['PHP_AUTH_PW']));
if ($stmt_select = mysqli_prepare($dbc, "SELECT userid, username FROM mybloguser WHERE username=? AND password=SHA(?)")) {
    mysqli_stmt_bind_param($stmt_select, "ss", $user_username, $user_password);
    if (!(mysqli_stmt_execute($stmt_select)))
    {
        echo 'Ошибка при выборке данных';
    }
    mysqli_stmt_bind_result($stmt_select, $id, $name);
    mysqli_stmt_fetch($stmt_select);
    mysqli_stmt_close($stmt_select);
    mysqli_close($dbc);
    if ($name == $user_username)
    {
        echo '<p>Вы вошли как '.$user_username.'</p>';
    }
    else
    {
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: Basic realm="MyBlog"');
        exit('Необходимо ввести пароль, чтобы войти');
    }

}


?>



</body>
</html>
