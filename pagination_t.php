<?php
for ($i=1; $i<=$num_pages; $i++)
{
    if ($cur_page==$i){
        echo '<a href="/index.php?page='.$i.'" class="active">'.$i.'</a>';
    }else{
        echo '<a href="/index.php?page='.$i.'">'.$i.'</a>';
    }

}
