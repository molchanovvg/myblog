<div id="sidebar">
    <!-- Logo -->
    <h1 id="logo"><a href="index.php">Myblog</a></h1>
    <!-- Text -->
    <section class="box text-style1">
        <div class="inner">
            <p><strong>Myblog</strong> <br/>Проект для изучения PHP</p>
        </div>
    </section>
    <!-- Nav -->
    <nav id="nav">
        <ul>
            <!-- <li class="current"> .-->
            <!-- <li class="current"> .-->

            <?php
            if (isset($_SESSION['username']))
            {
                ?>
                <li>Вы можете оставлять комменты</li>
                <li><a href="/logout.php">Выход</a></li>
                <?php
                if ($_SESSION['right']=='1')
                {
                    ?>
                    <li><a href="/add.php">Добавление статей</a></li>
                    <li><a href="/manage.php">Редактирование статей</a></li>
                    <?php
                }
            }
            else
            {
                ?>
                <li><a href="/login.php">Вход</a></li>
                <li><a href="/signup.php">Регистрация</a></li>
                <?php
            }

            ?>
        </ul>
    </nav>


    <!-- Copyright -->
    <ul id="copyright">
        <li>&copy; Molchanov VG</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
    </ul>

</div>