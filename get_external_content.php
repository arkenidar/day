<?php
function file_get_contents_curl($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

$url = $_REQUEST["url"];
$html = file_get_contents_curl($url);

preg_match('/<title>(.*)<\/title>/',$html,$matches);
$title = $matches[1];

function out_link($url,$title){
$out=file_get_contents("out.html");
$url=htmlspecialchars($url);
$title=htmlspecialchars($title);
$add="<a href='$url'>$title</a>";
file_put_contents("out.html","$add<br>\n$out");
}

out_link($url,$title);
//echo file_get_contents("out.html");
header("Location: ."); // redirect

echo json_encode(array(
    "url" => $url,
    "title" => $title));
