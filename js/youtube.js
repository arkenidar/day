function youtube_html_from_video_id(video_id){
    var youtube_html = /*html*/`<iframe width="560" height="315" src="https://www.youtube.com/embed/${video_id}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`
    return youtube_html
}

var youtube_video_url_start = "https://www.youtube.com/watch?v="
for(var entry of document.querySelectorAll(".entry")){
    var link_tag = entry.querySelector("a")
    if(link_tag.href.startsWith(youtube_video_url_start)){
        var video_id = link_tag.href.replace(youtube_video_url_start,"")
        console.log("found video_id: " + video_id)
        var youtube_html = youtube_html_from_video_id(video_id)
        entry.insertAdjacentHTML("beforeend",youtube_html)
    }
}