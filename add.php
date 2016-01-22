<html xmlns="http://www.w3.org/1999/html">
    <meta charset="utf-8"/>
    <title>MyBlog</title>
<body>
<a href="index.php">На главную</a>
<?php
require_once('connectvars.php');
if (isset($_POST['submit']))
{
    $header=trim($_POST['header']);
    $record=trim($_POST['record']);

    if (!empty($header)&& !empty($record))
    {
        //connect db
        $dbc = new mysqli(DB_HOST,DB_USER, DB_PASSWORD, DB_NAME);
        $header=mysqli_real_escape_string($dbc,$header);
        $record=mysqli_real_escape_string($dbc,$record);
        mysqli_set_charset($dbc, "utf8");
        $query = "INSERT INTO recordtable VALUES (0, NOW(), '$header','$record')";

        mysqli_query($dbc,$query);

        echo '<p>Вы добавили запись.</p>';
        $header="";
        $record="";

        mysqli_close($dbc);
    }
    else
    {
        echo '<p>Чего-то не хватает :(.</p>';
    }
}
?>

<p>Добавление новой записи в блог</p>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="header">Заголовок:</label><br>
    <input type="text" name="header" id="header"><br>
    <label for="record">Текст:</label><br>
    <textarea name="record" cols="80" rows="20" id="record"></textarea><br>
    <input type="submit" value="Поделиться" name="submit">
</form>
</body>
</html>