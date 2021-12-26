<!doctype html>
<html>
<head>
<title>day</title>
<meta name="viewport" content="width=device-width">
<meta charset="UTF-8">
</head>
<body>
<script src="jquery.js"></script>

<form action="submit.php">
<input type="url" name="url">
<input type="submit">
</form>

<link href="css/entry.css" rel="stylesheet">
<div id="out"></div>
<script>
$.ajaxSetup({cache:false});
$("#out").load("out.html");
</script>

</body>
</html>
