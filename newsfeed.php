<?php header('Content-Type: text/xml'); ?>
<?php echo '<?xml version="1.0" encoding="utf-8"?>';?>
<rss version="2.0">
<channel>
    <title>Myblog</title>
    <link>http://myblog</link>
    <description>Мой блог основанный на PHP/MySQL</description>
    <language>ru-ru</language>
<?php
require_once('core.php');
$query= "SELECT id, date, head, rec FROM recordtable ORDER BY date DESC";
if ($result=$dbc->query($query))
{
    while ($row=mysqli_fetch_array($result))
    {
        echo '<item>';
        echo '<title>'.$row['head'].'</title>';
        echo '<link>'.'http://myblog/viewpost.php?id=' . $row['id'].'</link>';
        echo '<pubDate>'.$row['date'].'</pubDate>';
        echo '<description>'.substr($row['rec'],0,300).'</description>';
        echo '</item>';
    }
}
mysqli_close($dbc);
?>
</channel>
</rss>
