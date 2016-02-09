<?php

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
$where_clause = implode(' OR ', $where_list);
$query="SELECT id, date, head, rec FROM recordtable WHERE ".$where_clause;