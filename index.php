<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8"/>
    <title>MyBlog</title>
<body>
<a href="add.php">Добавление статей</a><br>
<a href="manage.php">Редактирование статей</a>
<h1>MyBlog</h1>
<p>Здесь можно увидеть записи MyBlog</p>
<?php
    require_once('connectvars.php');
    $dbc = new mysqli(DB_HOST, DB_USER,DB_PASSWORD, DB_NAME);
    if ($dbc->connect_error)
    {
        die('Error connection Mysql-server ('.$dbc->connect_error.')');
    }
    $query="select * from recordtable ORDER BY date DESC";
    if ($result=$dbc->query($query))
    {
        while ($row=mysqli_fetch_array($result))
        {
            echo '<h1>'.$row['head'].'</h1>';
            echo '<br>';
            echo '<small>'.$row['date'].'</small>';
            echo '<br>';
            echo '<p>'.$row['rec'].'</p>';
            echo '<br>';
        }
    }
    mysqli_close($dbc);

?>
</body>
</html>