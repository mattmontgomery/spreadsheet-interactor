<?php

namespace Matt;

require_once(__DIR__ . '/../vendor/autoload.php');

use Rocket\UI\Table\Table;


$tsv = file_get_contents(__DIR__ . '/responses.tsv');

$dates = [];
$votes = [];

$rows = explode("\n",$tsv);
$playerDate = [];
foreach($rows as $row) {
    if(!$row) { continue; }
    $cells = explode("\t", $row);
    $date = date('m', strtotime($cells[0]));
    if(empty($votes[$date])) {
        $votes[$date] = 0;
    }
    $votes[$date]++;
    if(!empty($cells[1])) {
        $players = clean($cells[1]);
        foreach(explode(',',$players) as $player) {
            $player = trim($player);
            if(empty($dates[$player][$date])) {
                $dates[$player][$date] = 0;
            }
            $dates[$player][$date]++;
        }
    }
}
var_export($votes);
echo "<table>\n";
$row = '<thead><tr><th></th>';
foreach($votes as $d=>$vote) {
    $row .= "<th>" . $vote . "</th>";
}
$row .= '</tr><tr><th>Player</th>';
foreach($votes as $d=>$vote) {
    $row .= "<th>" . $d . "</th>";
}
$row .= '</tr></thead>';
echo $row;
foreach($dates as $player=>$results) {
    $row = "<tr><td>{$player}</td>";
    foreach($votes as $d=>$vote) {
        $row .= "<td>" . (empty($results[$d]) ? 0 : $results[$d]) . "</td>";
    }
    $row .= "</tr>\n";
    echo $row;
}
echo "</table>";
// echo $table->render();
function clean($string) {
   // $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   return preg_replace('/[^A-Za-z0-9\ \(\),\-]/', '', $string); // Removes special chars.
}
