<!doctype html>
<html>
<head>
<title>day</title>
<meta name="viewport" content="width=device-width">
<meta charset="UTF-8">
</head>
<body>

<form action="submit.php" method="POST">

<input type="url" name="url" placeholder="URL">
<input type="submit">

<input type="email" name="email" placeholder="e-mail address">
<input type="password" name="password" placeholder="pass-word">

</form>

<link href="css/entry.css" rel="stylesheet">

<div id="out">
<?php include( file_get_contents("latest.txt") ); ?>
</div>

</body>
</html>
