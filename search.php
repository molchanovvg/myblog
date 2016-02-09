<?php
$PageTitle='Результаты поиска';
require_once('header_t.php');
require_once('connectvars.php');
require_once('connectdb_t.php');
session_start();

function refValues($arr)
{       if (strnatcmp(phpversion(),'5.3') >= 0)
        {
            //Если версия PHP >=5.3 (в младших версиях все проще)
            $refs = array();
            foreach($arr as $key => $value)
            {
                $refs[$key] = &$arr[$key]; //Массиву $refs присваиваются ссылки на значения массива $arr
            }
            return $refs; //Массиву $arr присваиваются значения массива $refs
         }
        return $arr; //Возвращается массив $arr
}//function refValues($arr)

    $type='';
    $search=trim(strip_tags($_POST['search']));
    $clean_search=str_replace(',',' ',$search);
    $search_word=explode(' ', $clean_search);
    $final_search_word=array();
    if (count($search_word)>0)
    {
        foreach ($search_word as $word)
        {
            if (!empty($word))
            {
                $final_search_word[]='%'.$word.'%';
                $where_list[]="rec LIKE ?";
                $type.='s';
            }

        }
        

    }
  /*  if (count($final_search_word)>0)
    {
        foreach($final_search_word as $word)
        {
            $where_list[]="rec LIKE ?";
            $type.='s';
        }
    }*/
    $where_clause = implode(' OR ', $where_list);
    $query="SELECT id, date, head, rec FROM recordtable WHERE ".$where_clause;
?>
<div id="wrapper">
    <!-- Content -->
    <div id="content">
        <div class="inner">
            <!-- Post -->
            <?php
            if (isset($_POST['submit']))
            {
               // $search='%'.trim(strip_tags($_POST['search'])).'%';
                if ($stmt_select = mysqli_prepare($dbc, $query)) // "SELECT id, date, head, rec FROM recordtable WHERE rec LIKE ? "
                {
                    call_user_func_array('mysqli_stmt_bind_param', array_merge(array($stmt_select, $type), refValues($final_search_word)));
                    //mysqli_stmt_bind_param($stmt_select, "s", $search); // work
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