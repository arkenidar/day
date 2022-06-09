<!doctype html>
<html>
<head>
<title>day</title>
<meta name="viewport" content="width=device-width">
<meta charset="UTF-8">
</head>
<body>

<form action="submit.php">
<input type="url" name="url">
<input type="submit">
</form>

<link href="css/entry.css" rel="stylesheet">
<div id="out">
<?php include( file_get_contents("latest.txt") ); ?>
</div>
</body>
</html>
