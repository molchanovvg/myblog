<?php

if (!isset($_SESSION['user_id']))
{
    if (isset($_COOKIE['user_id']))
    {
        if ($stmt_select = mysqli_prepare($dbc, "select userid, username, userright from mybloguser WHERE userid=?"))
        {
            mysqli_stmt_bind_param($stmt_select, "i", $_COOKIE['user_id']);
            if (!(mysqli_stmt_execute($stmt_select)))
            {
                echo 'Ошибка при выборе записи';
            };
            mysqli_stmt_bind_result($stmt_select, $_SESSION['user_id'], $_SESSION['username'], $_SESSION['right']);
            mysqli_stmt_fetch($stmt_select);
            mysqli_stmt_close($stmt_select);

        };

    }

}