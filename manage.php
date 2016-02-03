<?php
$PageTitle='Управление';
require_once('header_t.php');
require_once('connectvars.php');
require_once('connectdb_t.php');
session_start();
if (isset($_SESSION)&& $_SESSION['right'] != 1)
{
    exit('У вас нет доступа к данной странице.');
}
?>

<div id="wrapper">

    <!-- Content -->
    <div id="content">
        <div class="inner">
            <?php
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
                        echo '<a href="/edit.php?id=' . $row['id'] . '">Редактировать</a>';
                        echo '<a href="/remove.php?id=' . $row['id'] . '">Удалить</a>';
                        echo '<br>';
                    }
                }
                mysqli_close($dbc);

            ?>
        </div>
    </div>

<?php
require_once('sidebar_t.php');
?>
</div>

</body>
</html>