function loadUsersOnline(){
	$.get("functions.php?usersonline=result", function(data){ // ?usersonline = parameter so we find the function in the .php
	// the second one is function that we execute when get back on the server
	$(".usersonline").text(data);
});

}

setInterval(function(){

	loadUsersOnline();

},500);

loadUsersOnline();