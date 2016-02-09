<?php
$PageTitle='Управление';
require_once('header_t.php');
require_once('connectvars.php');
require_once('connectdb_t.php');
require_once('check_adm_t.php');

?>

<div id="wrapper">

    <!-- Content -->
    <div id="content">
        <div class="inner">
            <?php
                ?>
                <p>Здесь можно отредактировать или удалить записи MyBlog</p>
                <?php
                $query = 'SELECT id, date, head, rec FROM recordtable ORDER BY date DESC';
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