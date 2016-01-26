<!DOCTYPE HTML>
<html>
    <head>
        <title>MyBlog</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
        <script src="js/jquery.min.js"></script>
        <script src="js/skel.min.js"></script>
        <script src="js/skel-layers.min.js"></script>
        <script src="js/init.js"></script>
        <noscript>
            <link rel="stylesheet" href="css/skel.css" />
            <link rel="stylesheet" href="css/style.css" />
            <link rel="stylesheet" href="css/style-desktop.css" />
            <link rel="stylesheet" href="css/style-wide.css" />
        </noscript>
        <!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
    </head>

    <body class="left-sidebar">
    <?php
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
                               
                        
                        

                            <!-- Pagination 
                                <div class="pagination"> -->
                                    <!--<a href="#" class="button previous">Previous Page</a>
                                    <div class="pages">
                                        <a href="#" class="active">1</a>
                                        <a href="#">2</a>
                                        <a href="#">3</a>
                                        <a href="#">4</a>
                                        <span>&hellip;</span>
                                        <a href="#">20</a>
                                    </div>
                                    <a href="#" class="button next">Next Page</a>
                                </div>
                                    -->
                        </div>
                    </div>

            <?php
            require_once('sidebar_t.php');
            ?>
        </div>
    </body>
</html>