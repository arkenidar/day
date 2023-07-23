<?php

session_start(); $_SESSION["loggedin"] or die("error: you aren't authorized!\n");

$url = $_REQUEST["url"];
filter_var($url, FILTER_VALIDATE_URL) or die("error: invalid URL!\n");

/*
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
*/
function url_title(&$url){
    //$html = file_get_contents_curl($url);
    $html = 'html?';
    
    preg_match('/<title>(.*)<\/title>/',$html,$matches);
    $title = (string)@$matches[1];
    if($title=="") $title=$url; // no title
    return $title;
}

function replace_lt_gt($text){
    $text=str_replace("<","&lt;",$text);
    $text=str_replace(">","&gt;",$text);
    return $text;
}

require("lib/lib-fetch.php");

function out_link($url,$title){
$url=replace_lt_gt($url);
$title=replace_lt_gt($title);
date_default_timezone_set('Europe/Rome');
$timestamp=date("Y-m-d|H-i-s",time());
$htmlsafe_url = htmlspecialchars($url, ENT_QUOTES | ENT_HTML5); // safer, more robust too
$new="<a href='$htmlsafe_url' data-timestamp='$timestamp'>($timestamp) $title</a>";
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
/// $title_out = url_title($url);
$title_out = title_from_URL($url);
$new .= out_link($url,$title_out);

/*
// youtube.com video embed / preview
if(false !== strpos($url,"youtube.com")){
    $new .= out_youtube($url);
}
*/

$new .= "</div>\n";

//$out_file="out.html";
$out_file=file_get_contents("latest.txt");
$previous=(string)@file_get_contents($out_file);
if(false===file_put_contents($out_file,$new.$previous)) die("can't write file"); // prepend text

header("Location: ."); // redirect
