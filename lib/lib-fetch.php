<?php

function title_from_URL($url){

    function file_get_contents_curl($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    $html = file_get_contents_curl($url);

    function title_from_HTML($html, $no_title_fallback){
        preg_match('/<title>(.*?)<\/title>/',$html,$matches);
        if(!isset($matches[1])) $title = $no_title_fallback; else
        $title = $matches[1];
        return $title;
    }

    $title = title_from_HTML($html, $url);

    return $title;
}
