// page by URL
function page_load(entry){
  var url = entry.querySelector("a[data-timestamp]").href

  // preview
  if(url.endsWith(".txt")) addPage(url,entry)
  else if(url.endsWith(".html")) addPage(url,entry)
  else if(url.endsWith(".htm")) addPage(url,entry)
  else if(url.endsWith(".md")) addPage(url,entry)

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

// this does handle <script> tags etc.
// source: https://arkenidar.com/web/editor.html
function nodeContentFromCode(code, node) {
  var range = document.createRange()
  range.selectNode(document.body)
  var documentFragment = range.createContextualFragment(code)
  node.innerHTML = ""
  node.appendChild(documentFragment)
}

var showdownConverter = new showdown.Converter()
function addPage(url,entry){
    var html='&nbsp;<a href="edit.php?URL='+url+'">modify</a>'
    var preview = getResponseText(url)

    // (optional) MarkDown (.md) formatting to HTML by use of "show-down" converter ("showdown" is a code-library that provides this feature)
    if(url.endsWith(".md")) preview = showdownConverter.makeHtml( preview )
    
    // [entry] entries can now contain HTML+JS

    //html += "<pre>"+preview+"</pre>" // page preview // this changes HTML formatting
    // case exception: if text file then wrap it with <pre> tags 
    if(url.endsWith(".txt")) html += "<pre>"+preview+"</pre>"; else
    html += preview // page preview
    
    //entry.insertAdjacentHTML("beforeend", html) // this doesn't properly handle e.g. <script> tags
    nodeContentFromCode(html, entry) // this does handle <script> tags etc.
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


