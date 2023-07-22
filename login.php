<?php session_start();
include "secrets.php";
if(!isset($secret_password)) die("error: missing a secrets.php file!");
if(isset($_REQUEST["submit-enter"]) && $_REQUEST["password"]==$secret_password){
$_SESSION["loggedin"]=true;
}
if(isset($_REQUEST["submit-exit"])){
$_SESSION["loggedin"]=false;
}
?><!doctype html> <html lang="en"> <head>

<title>enter</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">

</head><body>

<a href=".">go to main page</a>
<br>
<form action="" method="post">
Condition: <?=$_SESSION["loggedin"]?"access enabled":"access not enabled"?>
<input type="submit" value="exit" name="submit-exit"><br>
<hr>
<input type="email" name="email" placeholder="e-mail address">
<input type="password" name="password" placeholder="pass-word">
<input type="submit" value="enter" name="submit-enter">
</form>

</body></html>
