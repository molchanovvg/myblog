<?php
$doc_rss = simplexml_load_file("header_rss.xml");

require_once('core.php');
libxml_use_internal_errors(true);

if ($doc_rss === false) {
    echo "Ошибка загрузки XML\n";
    foreach(libxml_get_errors() as $error) {
        echo "\t", $error->message;
    }
}

$query= "SELECT id, date, head, rec FROM recordtable ORDER BY date DESC";
if ($result=$dbc->query($query))
{
    while ($row=mysqli_fetch_array($result))
    {
        $item = $doc_rss->addChild('item');
        $item->addChild('title', $row['head']);
        $item->addChild('link', 'http://myblog/viewpost.php?id=' . $row['id']);
        $item->addChild('pubDate', $row['date']);
        $item->addChild('description', substr($row['rec'],0,300));
    }
}
mysqli_close($dbc);
$dom = new DOMDocument("1.0");
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($doc_rss->asXML());
echo $dom->saveXML();