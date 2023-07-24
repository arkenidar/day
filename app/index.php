<!doctype html>
<html lang="en">
<head>
<title>day</title>
<meta name="viewport" content="width=device-width">
<meta charset="UTF-8">
</head>
<body>

<form action="submit.php" method="POST">

<input type="url" name="url" placeholder="URL">
<input type="submit">

<a href="login.php" target="_blank">login</a>

</form>

<script>function days_load(button){ load_entries( `../days/day-${button.textContent}.html` ) }</script>
<button onclick="days_load(this)">01</button>
<button onclick="days_load(this)">02</button>
<button onclick="days_load(this)">03</button>

<!-- section -->

<div id="entries"></div>

<!-- section -->

<script src="https://cdn.jsdelivr.net/npm/showdown@2.1.0/dist/showdown.min.js"></script>
<script src="../js/page.js"></script>
<script>
load_entries( getResponseText("../days/latest.txt") )
function load_entries(URL){
    var node = document.querySelector("#entries")
    node.innerHTML=""
    nodeContentFromCode(getResponseText( URL ), node )
}
</script>

</body>
</html>
