<?php
// https://github.com/arkenidar/tools for requiring login
session_start(); $_SESSION["loggedin"] or die("error: you aren't authorized!\n");

$url = $_REQUEST["url"];
//$url="https://www.youtube.com/watch?v=ADzC1-DXfb4";

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
    if($title=="") $title=$url." (NO-TITLE)";
    return $title;
}

function out_link($url,$title){
$url=htmlspecialchars($url);
$title=htmlspecialchars($title);
date_default_timezone_set('Europe/Rome');
$timestamp=date("Y-m-d|H-i-s",time());
$new="<div><a href='$url' data-timestamp='$timestamp'>($timestamp) $title</a></div>";
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

function str_starts($string,$query){ // not PHP8
    return substr($string, 0, strlen($query)) === $query;
}

$new="<div class='entry'>";

// link
$title_out = url_title($url);
$new .= out_link($url,$title_out);

// youtube.com video embed / preview
if(str_starts($url,"https://www.youtube.com")){
    $new .= out_youtube($url);
}

// page by URL
if(filter_var($url, FILTER_VALIDATE_URL) && str_ends_with($url,".page.txt") && str_starts_with($url,"https://arkenidar.com/app/pages/")){
    ob_start(); // HTML Output Buffering
?>
<script src="js/page.js"></script>
<script>page_load("<?= $url ?>")</script>
<?php

    $text = ob_get_contents(); ob_end_clean();

    $new.=$text."\n";
} // if

$new.="</div>\n";

$out_file="out.html";
$previous=(string)@file_get_contents($out_file);
if(false===file_put_contents($out_file,$new.$previous)) die("can't write file"); // prepend text

header("Location: ."); // redirect
