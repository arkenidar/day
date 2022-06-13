<?php

require_once("login.php"); is_logged() or die("error: you aren't authorized!\n");

$url = $_REQUEST["url"];
filter_var($url, FILTER_VALIDATE_URL) or die("error: invalid URL!\n");

function file_get_contents_curl(&$url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $data = curl_exec($ch);
    $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);
    return $data;
}

function url_title(&$url){
    $html = file_get_contents_curl($url);

    preg_match('/<title>(.*)<\/title>/',$html,$matches);
    $title = (string)@$matches[1];
    if($title=="") $title=$url; // no title
    return $title;
}

function out_link($url,$title){
$url=htmlspecialchars($url);
$title=htmlspecialchars($title);
date_default_timezone_set('Europe/Rome');
$timestamp=date("Y-m-d|H-i-s",time());
$new="<a href='$url' data-timestamp='$timestamp'>($timestamp) $title</a><br>";
return $new;
}

function out_youtube($url){

parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
if(array_key_exists('v',$my_array_of_vars)==false) return "";
$video_id=$my_array_of_vars['v'];

$video_id=htmlspecialchars($video_id);
$new='<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$video_id.'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

return $new;
}

$new="<div class='entry'>";

// link
$title_out = url_title($url);
$new .= out_link($url,$title_out);

// youtube.com video embed / preview
if(str_starts_with($url,"https://www.youtube.com")){
    $new .= out_youtube($url);
}

$new .= '<script src="js/page.js"></script><script>page_load()</script>';

$new .= "</div>\n";

$out_file="out.html";
$previous=(string)@file_get_contents($out_file);
if(false===file_put_contents($out_file,$new.$previous)) die("can't write file"); // prepend text

header("Location: ."); // redirect
