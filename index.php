    <?php
    require_once('core.php');
    $PageTitle='Простой блог основанный на PHP MySQL';
    require_once('header_t.php');
    require_once('navi.php');

    session_start();
    ?>
        <div id="wrapper">
            <!-- Content -->
                    <div id="content">
                        <div class="inner">
                            <!-- Post -->
                            <?php
                                 $query= "SELECT id, date, head, rec FROM recordtable ORDER BY date DESC LIMIT $skip, $result_per_page";
                                    if ($result=$dbc->query($query))
                                    {
                                        while ($row=mysqli_fetch_array($result))
                                        {
                                            ?>
                                            <article class="box post post-excerpt">
                                                <header>
                                                    <h2><?php echo $row['head'] ?></h2>
                                                </header>
                                                <div class="info">
                                                        <span class="date">
                                                            <span class="month"><?php echo date_create($row['date'])->Format('M') ?></span>
                                                            <span class="day"><?php echo date_create($row['date'])->Format('d') ?></span>
                                                            <span class="year"><?php echo date_create($row['date'])->Format('y') ?></span>
                                                        </span>
                                                </div>

                                                <p>
                                                    <?php echo substr($row['rec'],0,300) ?>...
                                                </p>
                                                <?php
                                                echo '<a href="/viewpost.php?id=' . $row['id'] . '"">Просмотреть полностью</a>';
                                                ?>
                                            </article>
                                            <?php
                                        }
                                    }
                                    mysqli_close($dbc);
                            ?>

                        </div>
                        <!-- Pagination -->
                        <div class="pagination">

                            <div class="pages">
                                <?php
                                require_once('pagination_t.php');
                                ?>
                            </div>
                        </div>
                    </div>
            <?php
            require_once('sidebar_t.php');
            ?>
        </div>
    </body>
</html>