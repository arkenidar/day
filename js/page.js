// page by URL
function page_load(entry){
  var url = entry.querySelector("a[data-timestamp]").href

  // preview
  if(url.endsWith(".txt")) addPage(url,entry)
  else if(url.endsWith(".html")) addPage(url,entry)
  else if(url.endsWith(".htm")) addPage(url,entry)
  
  else if(url.endsWith(".png")) addImage(url,entry)
  else if(url.endsWith(".jpg")) addImage(url,entry)
  else if(url.endsWith(".jpeg")) addImage(url,entry)

  else if(url.endsWith(".mp4")) addVideo(url,entry)
  else if(url.endsWith(".webm")) addVideo(url,entry)
}

function addImage(url,entry){
  var html='<br><img width="95%" height="55%" src="'+url+'">' // image preview
  entry.insertAdjacentHTML("beforeend", html)
}

function addVideo(url,entry){
  var type
  if(url.endsWith(".mp4"))
    type = "video/mp4"
  else if(url.endsWith(".webm"))
    type = "video/webm"

  // video preview
  var html='<br><video controls width="95%" height="55%" ><source src="'+url+'" type="'+type+'"></video>'

  entry.insertAdjacentHTML("beforeend", html)
}

var showdownConverter = new showdown.Converter()
function addPage(url,entry){
    var html='&nbsp;<a href="edit.php?URL='+url+'">edit</a>'
    var preview = showdownConverter.makeHtml( getResponseText(url) )
    html += "<pre>"+preview+"</pre>" // page preview
    entry.insertAdjacentHTML("beforeend", html)
}

function getResponseText(url){
  var xhr = new XMLHttpRequest()
  xhr.open('GET', url, false)
  xhr.setRequestHeader('Cache-Control', 'no-cache')
  var text
  xhr.onload = function(){ text=xhr.responseText }
  xhr.send()
  return text
}

document.querySelector("#out").innerHTML = getResponseText( getResponseText("latest.txt") )
for(var entry of document.querySelectorAll(".entry")) page_load( entry )
