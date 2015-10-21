$(document).ready(function(){
	$("#contact_reset").click(function(){
		document.getElementById("contact").reset();		
	});
	$("#contact_submit").click(function(){
		var answer = confirm("Are you sure you want to send this contact!");
		if(answer){			
			document.getElementById("contact").submit();
		}
	});
});