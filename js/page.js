// page by URL
function page_load(entry){
  var url = entry.querySelector("a[data-timestamp]").href

  // preview
  if(url.endsWith(".txt")) addPage(url,entry)
  else if(url.endsWith(".png")) addImage(url,entry)
}

function addImage(url,entry){
  var html='<img src="'+url+'">' // preview
  entry.insertAdjacentHTML("beforeend", html)
}

function addPage(url,entry){
    var html='<a href="edit.php?URL='+url+'">edit</a>'
    html += "<pre>"+getResponseText(url)+"</pre>" // preview
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
