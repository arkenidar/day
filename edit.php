<?php session_start(); $_SESSION["loggedin"] or die("error: you aren't authorized!\n"); ?>
<!doctype html>
<title>editor</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">

<?php

$filename=$_REQUEST['filename'];

if(isset($_REQUEST['URL'])){
    $URL=$_REQUEST['URL'];
    $server_name=$_SERVER['SERVER_NAME'];
    $filename=str_replace("https://$server_name/app/pages/","/var/www/$server_name/app/pages/",$URL);
} 

if(isset($_REQUEST['file_content']))
if(false=== file_put_contents($filename,$_REQUEST['file_content']) ) die("can't write file");

?>

<form method="post">
<input type="submit" value="save"> <input value="<?=htmlentities($filename)?>" id="filename">
<button onclick="setTimeout(()=>location='?filename='+filename.value)">open</button> <br>

<textarea name="file_content" rows=50 cols=50><?=htmlentities(file_get_contents($filename))?></textarea>

</form>