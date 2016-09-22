var localCss = document.createElement('style');
localCss.type = 'text/css';
localCss.id = 'jsstyle';
localCss.innerHTML += top.document.getElementById('gskw').innerHTML;

var fontSize = /fontsize=([^&]+)/.exec(location)[1];
var localCssFont = document.createElement('style');
var cssString = "*{font-size: "+ fontSize +"% !important;}.phonetic-script{font-family: 'Open Sans', sans-serif;}";
localCssFont.type = 'text/css';
localCssFont.id = 'fontcss';
localCssFont.innerHTML += cssString;

document.head.appendChild(localCss);
document.head.appendChild(localCssFont);
function touchWordHandler(e){
    var word = e.target.className.split(' ')[0];
    var user = /user=([^&]+)/.exec(location)[1];
    console.log(user);
    console.log(word);

    var cssString = '.phonetic-script.'+ word +'{display:none;}';
    var globalCssElement = top.document.getElementById('gskw');

    console.log(globalCssElement);
    xhttp = new XMLHttpRequest();
    if (globalCssElement.innerHTML.indexOf(cssString) != -1){
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200){
                console.log(this.responseText);

                globalCssElement.innerHTML = globalCssElement.innerHTML.replace(cssString, '');
                var iframes = top.document.getElementsByTagName("iframe");
                for (var i = 0; i < iframes.length; i++) {
                    iframes[i].contentDocument.getElementById('jsstyle').innerHTML = globalCssElement.innerHTML;
                }
            }
        }

        xhttp.open('POST', '/api.php', true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send('func=cws&user='+ user +'&word=' + word + '&kl=0');
    }else{
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200){
                console.log(this.responseText);

                globalCssElement.innerHTML += cssString;
                var iframes = top.document.getElementsByTagName("iframe");
                for (var i = 0; i < iframes.length; i++) {
                    iframes[i].contentDocument.getElementById('jsstyle').innerHTML = globalCssElement.innerHTML;
                }
            }
        }

        xhttp.open('POST', '/api.php', true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send('func=cws&user='+ user +'&word=' + word + '&kl=1');
    }
}

document.addEventListener('click', touchWordHandler);
document.addEventListener('touchstart', touchWordHandler);
