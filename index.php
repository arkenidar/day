<!doctype html>
<html>
<head>
<title>day</title>
<meta name="viewport" content="width=device-width">
<meta charset="UTF-8">
</head>
<body>
<!--
<script src="jquery.js"></script>
<script>function url_get(){
var url=$("#url").val()
//alert(url)
get_title(url)
function get_title(external_url){
//https://stackoverflow.com/questions/7901760/how-can-i-get-the-title-of-a-webpage-given-the-url-an-external-url-using-jquer
var proxyurl = "https://arkenidar.com/app/day/get_external_content.php?url=" + external_url;
$.ajax({
url: proxyurl,
async: true,
success: function(response) {
response=JSON.parse(response);
console.log(response);
alert(response.title);//testing
//location.reload(); //trick
var text=response.title;
var href=response.url;
if(!href.startsWith("http")) href="https://"+href;
var link=$("<a></a><br>").text(text).attr("href",href);
$("#out").append(link);
},   
error: function(e) {
alert("error! " + e);
console.log(e)
}
});
}
}</script>
-->
<form action="get_external_content.php">
<input type="url" name="url" id="url"><!--<button onclick="url_get()">URL</button>-->
<input type="submit">
</form>
<div id="out"><?=file_get_contents("out.html")?></div>
<script>
//$(()=>alert("now jquery"))
//alert("now script")
</script>
</body>
</html>
