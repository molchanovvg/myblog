<?php
$all_record_count="";
$query = "select id, date, head, rec from recordtable order by date desc";
if ($result=$dbc->query($query))
{
    $all_record_count=mysqli_num_rows($result); // всего записей
}
$cur_page=isset($_GET['page']) ? $_GET['page'] : 1; //текущий номер страницы
$result_per_page=5; // количество записей на странице
$skip=(($cur_page-1)*$result_per_page); // сколько записей пропустить
$num_pages=ceil($all_record_count/$result_per_page);

?>