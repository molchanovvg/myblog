<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title>Edit Page</title>
</head>
<body>
<a href="index.php">На Главную</a>
<p>Редактирование записи</p>
<?php
require_once('connectvars.php');


    if (isset($_GET['id'])&& isset($_GET['head']))
    {
        $id=$_GET['id'];
        $head=$_GET['head'];
    }
    else if (isset($_POST['id'])&& isset($_POST['header']))
         {
             $id=$_POST['id'];
             $head=trim($_POST['header']);
             $rec=trim($_POST['record']);
         }
         else
         {
             echo '<p>Нет данных для редактирования.</p>';
         }
    if (isset($_POST['submit']))
    {
        $dbc = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($dbc->connect_error)
        {
            die('Error connection Mysql-server ('.$dbc->connect_error.')');
        }
        $head=mysqli_real_escape_string($dbc, $head);
        $rec=mysqli_real_escape_string($dbc, $rec);
        $query = "UPDATE recordtable SET head = '$head', rec='$rec' WHERE id = '$id' ";
        mysqli_query($dbc,$query);
        mysqli_close($dbc);
        echo '<p>Рейтинг с заголовком ' . $head . ' был изменен</p>';

    }
    else if (isset($id)&& isset($head))
        {
           /* echo '<p>Вы уверены что хотите удалить?</p>';
            echo '<br>';
            echo '<p>'.$head.'</p>';
            echo '<form method="post" action="remove.php">';
            echo '<input type="radio" name="confirm" value="Yes" /> Yes';
            echo '<input type="radio" name="confirm" value="no" checked="checked" /> No <br>';
            echo '<input type="submit" value="submit" name="submit"/>';
            echo '<input type="hidden" name="id" value="'.$id.'"/>';
            echo '<input type="hidden" name="head" value="'.$head.'"/>';
            echo '</form>';*/
            $dbc = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $query="select * from recordtable WHERE id=$id";
            if ($result=$dbc->query($query))
            {
                $row=mysqli_fetch_array($result);
                $rec=$row['rec'];
            }
        ?>
            <form method="post" action="edit.php">
                <label for="header">Заголовок:</label><br>
                <input type="text" name="header" id="header" value="<?php echo $head ?>"><br>
                <label for="record">Текст:</label><br>
                <textarea name="record" cols="80" rows="20" id="record"><?php echo $rec ?></textarea><br>
                <input type="hidden" name="id" value="<?php echo $id ?>"/>
                <input type="submit" value="submit" name="submit">
            </form>
  <?php
}

?>



</body>
</html>