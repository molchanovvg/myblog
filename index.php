    <?php
    $PageTitle='Главная';
    require_once('header_t.php');
    require_once('connectvars.php');
    require_once('connectdb_t.php');
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
                                                    <?php echo $row['rec'] ?>
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
                                for ($i=1; $i<=$num_pages; $i++)
                                {
                                    if ($cur_page==$i)
                                    {
                                        echo '<a href="/index.php?page='.$i.'" class="active">'.$i.'</a>';
                                    }
                                    else
                                    {
                                        echo '<a href="/index.php?page='.$i.'">'.$i.'</a>';
                                    }

                                }
                                ?>
                               <!-- <a href="#" class="active">1</a>
                                <a href="#">2</a>-->

                            </div>

                        </div>
                    </div>

            <?php
            require_once('sidebar_t.php');
            ?>
        </div>
    </body>
</html>