
    <?php
    $PageName='MyBlog';
    require_once('header_t.php');
    session_start();
      if (!isset($_SESSION['user_id']))
      {
          if (isset($_COOKIE['user_id']) && isset($_COOKIE['username']))
          {
              $_SESSION['user_id'] = $_COOKIE['user_id'];
              $_SESSION['username'] = $_COOKIE['username'];
          }
      }

    require_once('connectvars.php');
    ?>
        <div id="wrapper">
            
            <!-- Content -->
                    <div id="content">
                        <div class="inner">
                    
                            <!-- Post -->
                            <?php
                                $dbc = new mysqli (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                                if ($dbc -> connect_error)
                                {
                                    die('Error connection Mysql-server ('.$dbc->connect_error.')');
                                }
                                $query = "select * from recordtable order by date desc";
                                mysqli_set_charset($dbc,'utf8');
                                if ($result=$dbc->query($query))
                                {
                                    while ($row=mysqli_fetch_array($result))
                                    {
                                        ?>
                                         <article class="box post post-excerpt">
                                            <header>
                                                <h2><a href="#"><?php echo html_entity_decode($row['head']) ?></a></h2>
                                            </header>
                                            <div class="info">
                                                <span class="date"><span class="month">Jul<span>y</span></span> <span class="day">14</span><span class="year">, 2014</span></span>
                                            </div>
                                          <!--  <a href="#" class="image featured"><img src="images/pic01.jpg" alt="" /></a> -->
                                            <p>
                                            <?php echo html_entity_decode($row['date']) ?>
                                            </p>
                                            <p>
                                            <?php echo html_entity_decode($row['rec']) ?>
                                            </p>
                                        </article>
                                        <?php
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