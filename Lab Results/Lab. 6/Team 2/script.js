window.onload = function(){
	$("#div").html("Hello");
	$("#FontSize").val(20);
	$("#FontSize").blur(applyFontSize());
	//$("#Border").blur(applyBorder());
	//$("#Text").blur(applyText());
}

function applyFontSize(){
	var size = $("#FontSize").val();
	/*var border = $("#Border").prop('checked');
	if(border == true)
		$("#div").html(border);
	else{
		$("#div").html("HELLO");
	}*/
	$("#div").css("font-size",size);
}

function applyText(){
	var texte = $("#Text").val();
	alert(texte);
	$("#div").html(texte);
}

function applyBorder(){
	var border = $("#Border").prop('checked');
	if(border == true)
		$("#div").css("border","1px solid black");
	else{
		$("#div").css("border","none");
	}
	//$("#div").css("font-size",size);
}