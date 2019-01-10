/*
 * Copyright (c) Oscar Cameron 2018.
 */

function showSuggestions(string){
    if(string.length == 0){
        ele = document.getElementById("searchBar");
        ele.innerHTML = "";
        return;
    }
    XMLHttp =new XMLHttpRequest();
    XMLHttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            ele.innerHTML=this.responseText;
        }
    };
    XMLHttp.open("GET", "../includes/searchBar.php?text="+string, true);
    XMLHttp.send();
}