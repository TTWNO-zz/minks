<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Minks Alpha</title>
  <script src="/epub.js/libs/jszip/jszip.min.js"></script>
  <script src="/epub.js/dist/epub.js"></script>
  <style type="text/css" id="gskw"></style>
  <style type="text/css">
    body {
      margin: 0;
      background: #fafafa;
      font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
      color: #333;
      height: 100%;
      width: 100%;
    }
    .epub-container {
      min-width: 320px;
      margin: 0 auto;
    }
      /*.epub-container > div {
        padding: 0 20% 0 20%;
      }*/
    .epub-container .epub-view > iframe {
        background: white;
        box-shadow: 0 0 4px #ccc;
        margin: 10px;
        padding: 20px;
    }
    #prev {
      left: 40px;
    }
    #next {
      right: 40px;
    }
    .arrow {
      position: fixed;
      top: 50%;
      margin-top: -32px;
      font-size: 64px;
      color: #E2E2E2;
      font-family: arial, sans-serif;
      font-weight: bold;
      cursor: pointer;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }
    .arrow:hover {
      color: #777;
    }
    .arrow:active {
      color: #000;
    }
    #toc {
      display: block;
      margin: 10px auto;
    }

    @import 'https://fonts.googleapis.com/css?family=Open+Sans&subset=latin-ext';
  </style>
</head>
<body>
  <div id="viewer"><p style="padding-left:1%;" id="load">Loading... Please wait (this make take up to 1 minute)</p></div>

  <script>
    var currentSectionIndex = 8;
    // Load the opf
    var bookName = /book=([^&]+)/.exec(location)[1];

    var book = ePub(<?php echo '"./books/"';?> + bookName);
    var rendition = book.renderTo("viewer", { method: "continuous", width: "100%"});
    var displayed = rendition.display();
    displayed.then(function(renderer){
      // -- do stuff
      var l = document.getElementById('load');
      l.remove();
    });
    // Navigation loaded
    book.loaded.navigation.then(function(toc){
      console.log(toc);
    });

    rendition.on("rendered", function(section){
        var doc = document.querySelectorAll("[href='"+ section.href +"']");
        console.log(section.href);
        console.log(section);
        console.log(doc);
    });

    rendition.hooks.content.register(function(view){
     return view.addScript("/js-files/events.js")
       .then(function(){
           //init code
       });
    });

    var user = /user=([^&]+)/.exec(location)[1];
    xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200){
            var globalCss = document.getElementById('gskw');
            globalCss.innerHTML += this.responseText;
        }
    }

    xhttp.open('POST', '/css/'+ user +'-words.css', true);
    xhttp.send();
  </script>

</body>
</html>
