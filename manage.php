<html>
<head>
    <meta charset="utf-8">
    <title>Edit Page</title>
</head>
<body>
<a href="index.php">На Главную</a>
<p>Здесь можно отредактировать или удалить записи MyBlog</p>
<?php
    require_once('connectvars.php');
    $dbc = new mysqli(DB_HOST, DB_USER,DB_PASSWORD, DB_NAME);
    if ($dbc->connect_error)
    {
        die('Error connecting Mysql server ('.$dbc->connect_error.')');
    }
    $query = 'select * from recordtable ORDER by date DESC';
    if ($result=$dbc->query($query))
    {
        while ($row=mysqli_fetch_array($result))
        {
            echo $row['date'].'  '.$row['head'].'  ';
            echo '<a href=edit.php?id='.$row['id'].'&amp;head='.$row['head'].'>Редактировать</a>';
            echo '<a href=remove.php?id='.$row['id'].'&amp;head='.$row['head'].'>Удалить</a>';
            echo '<br>';
        }
    }
    mysqli_close($dbc);
?>
</body>
</html>