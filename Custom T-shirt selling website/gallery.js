function openTab(evt, tabName) {
   var i, tablinks;
   
   document.getElementById("Log_in").style.display = "none";
   document.getElementById("Register").style.display = "none";
   document.getElementById("Size").style.display = "none";
   
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
	
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}



function closeTab(evt, tabName) {
    document.getElementById(tabName).style.display = "none";
	var tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
	document.getElementById("defaultOpen").click();
}



function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("topBtn").style.display = "block";
        document.getElementById("sizeBtn").style.display = "block";
    } else {
        document.getElementById("topBtn").style.display = "none";
        document.getElementById("sizeBtn").style.display = "none";
		document.getElementById("sizeTable").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
	document.getElementById("sizeTable").style.display = "none";
}

function sizeFunction() {
	document.getElementById("sizeTable").style.display = "block";
}