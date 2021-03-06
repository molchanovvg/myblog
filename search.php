<?php
require_once('core.php');
$PageTitle='Результаты поиска в php блоге';
require_once('header_t.php');
session_start();
require_once('search_t.php');
?>
<div id="wrapper">
    <!-- Content -->
    <div id="content">
        <div class="inner">
            <!-- Post -->
            <?php
            if (isset($_POST['submit']))
            {
                if ($stmt_select = mysqli_prepare($dbc, $query))
                {
                    call_user_func_array('mysqli_stmt_bind_param', array_merge(array($stmt_select, $type), refValues($final_search_word)));
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