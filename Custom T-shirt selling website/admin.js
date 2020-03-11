function openTab(evt, tabName) {
	
    var i, tabcontent, tablinks;
	
    tabcontent = document.getElementsByClassName("tabcontent");
	
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    
	tablinks = document.getElementsByClassName("tablinks");
    
	for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    
	document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}



function readURL(input) {
	
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#profile-img-tag').attr('src', e.target.result);
				document.getElementById(imgLoc).value = "selected";
            }
            reader.readAsDataURL(input.files[0]);
        }
}



