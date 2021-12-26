<?php

$url = $_REQUEST["url"];

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

function url_title($url){
    $html = file_get_contents_curl($url);

    preg_match('/<title>(.*)<\/title>/',$html,$matches);
    $title = $matches[1];
    return $title;
}

$out=file_get_contents("out.html");

function out_link($url,$title){
$url=htmlspecialchars($url);
$title=htmlspecialchars($title);
date_default_timezone_set('Europe/Rome');
$timestamp=date("Y-m-d|H-i-s",time());
$new="<a href='$url'>$title</a> [$timestamp]<br>";
return $new;
}

function out_youtube($url){

parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
if(array_key_exists('v',$my_array_of_vars)==false) return "";
$video_id=$my_array_of_vars['v'];

$video_id=htmlspecialchars($video_id);
$new='<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$video_id.'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

return "$new<br>\n";
}

function str_starts($string,$query){ // not PHP8
    return substr($string, 0, strlen($query)) === $query;
}

$new="";

// link
$title_out = url_title($url);
$new .= out_link($url,$title_out);    

// youtube.com video embed / preview
if(str_starts($url,"https://www.youtube.com")){
    $new .= out_youtube($url);
}

file_put_contents("out.html","$new\n$out");
//echo file_get_contents("out.html");
///echo url_title($url);
///echo $new;
header("Location: ."); // redirect

echo json_encode(array(
    "url" => $url,
    "title" => $title));
