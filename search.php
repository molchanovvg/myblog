<?php
$PageTitle='Результаты поиска';
require_once('header_t.php');
require_once('connectvars.php');
require_once('connectdb_t.php');
session_start();
?>
<div id="wrapper">
    <!-- Content -->
    <div id="content">
        <div class="inner">
            <!-- Post -->
            <?php
            if (isset($_POST['submit']))
            {
                $search='%'.trim(strip_tags($_POST['search'])).'%';
                if ($stmt_select = mysqli_prepare($dbc, "SELECT id, date, head, rec FROM recordtable WHERE rec LIKE ? "))
                {
                    mysqli_stmt_bind_param($stmt_select, "s", $search);
                    if (!(mysqli_stmt_execute($stmt_select)))
                    {
                        exit ('Ошибка при выборке записей: ' . mysqli_stmt_error($stmt_select));

                    }
                    mysqli_stmt_store_result($stmt_select);
                    mysqli_stmt_bind_result($stmt_select, $id, $date, $head, $rec);
                    if (mysqli_stmt_num_rows($stmt_select)>0)
                    {
                        while (mysqli_stmt_fetch($stmt_select))
                        {
                            ?>
                            <article class="box post post-excerpt">
                                <header>
                                    <h2><?php echo $head ?></h2>
                                </header>
                                <div class="info">
                                                <span class="date">
                                                    <span class="month"><?php echo date_create($date)->Format('M') ?></span>
                                                    <span class="day"><?php echo date_create($date)->Format('d') ?></span>
                                                    <span class="year"><?php echo date_create($date)->Format('y') ?></span>
                                                </span>
                                </div>

                                <p>
                                    <?php echo $rec ?>
                                </p>
                                <?php
                                echo '<a href="/viewpost.php?id=' . $id . '"">Просмотреть полностью</a>';
                                ?>
                            </article>
                            <?php

                        }
                    }
                    else
                    {
                        echo 'Ничего не найдено :(';
                    }
                    mysqli_close($dbc);

                }

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