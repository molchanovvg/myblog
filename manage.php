<?php
$PageTitle='Управление';
require_once('header_t.php');
require_once('connectvars.php');
require_once('connectdb_t.php');
require_once('authss_t.php');
?>

<div id="wrapper">

    <!-- Content -->
    <div id="content">
        <div class="inner">
            <?php
            if ((isset($_SESSION['user_id'])) && ($_SESSION['right']==1))
            {
                ?>
                <p>Здесь можно отредактировать или удалить записи MyBlog</p>
                <?php
                $dbc = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                if ($dbc->connect_error) {
                    die('Error connecting Mysql server (' . $dbc->connect_error . ')');
                }
                $query = 'SELECT * FROM recordtable ORDER BY date DESC';
                mysqli_set_charset($dbc, 'utf8');
                if ($result = $dbc->query($query)) {
                    while ($row = mysqli_fetch_array($result)) {
                        echo $row['date'] . '  ' . $row['head'] . '  ';
                        echo '<a href=edit.php?id=' . $row['id'] . '&amp;head=' . $row['head'] . '>Редактировать</a>';
                        echo '<a href=remove.php?id=' . $row['id'] . '&amp;head=' . $row['head'] . '>Удалить</a>';
                        echo '<br>';
                    }
                }
                mysqli_close($dbc);
            }
            else
            {
             echo '<p>У вас нет доступа</p>';
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