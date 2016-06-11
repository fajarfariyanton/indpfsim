<?php
$all= glob("KEYWORDS-DAFA/*.txt");
shuffle($all);

$array= array_filter(explode("\n", file_get_contents($all[array_rand($all)])));

foreach($array as $items){
$title= trim($items);
$slug= substr(uniqid(),9,4).'/'.str_replace(' ', '-', strtolower($title)).'.pdf';
$data[]= '<a href="http://'.$_SERVER['SERVER_NAME'].'/'.$slug.'" title="'.$title.'">'.$title.'</a><hr>';
}

echo implode('<br>', $data);