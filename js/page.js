// page by URL
function page_load(url){
  var scripts = document.getElementsByTagName("script")
  var thisScriptTag = scripts[ scripts.length - 1 ]

  addPage(url,thisScriptTag)
}

function addPage(url,thisScriptTag){
    var html="<pre style='white-space: pre-wrap;'>"+
    " preview: "+getResponseText(url)+"</pre>"
    thisScriptTag.insertAdjacentHTML("afterend", html)
}

function getResponseText(url){
  var xhr = new XMLHttpRequest()
  xhr.open('GET', url, false)
  var text
  xhr.onload = function(){ text=xhr.responseText }
  xhr.send()
  return text
}