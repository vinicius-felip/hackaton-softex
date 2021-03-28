<?php

require __DIR__ . '/../../includes/app.php';

use App\Model\Entity\Marker;

$where = isset($_GET['status']) ? "status = 'on'" : null;

function parseToXML($htmlStr)
{
    $xmlStr = str_replace('<', '&lt;', $htmlStr);
    $xmlStr = str_replace('>', '&gt;', $xmlStr);
    $xmlStr = str_replace('"', '&quot;', $xmlStr);
    $xmlStr = str_replace("'", '&#39;', $xmlStr);
    $xmlStr = str_replace("&", '&amp;', $xmlStr);
    return $xmlStr;
}

$results = Marker::getMarkers($where);

header("Content-type: text/xml");

echo "<?xml version='1.0' ?>";
echo '<markers>';

while ($marker = $results->fetchObject(Marker::class)){
    echo '<marker ';
    echo 'id="' . $marker->id . '" ';
    echo 'lat="' . $marker->lat . '" ';
    echo 'lng="' . $marker->lng . '" ';
    echo 'type="' . $marker->type . '" ';
    echo '/>';
}

echo '</markers>';
