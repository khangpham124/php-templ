/* HEADER SP MENU */
$(function(){
	$("#btnMenu").click(function() {
		if ($(this).hasClass("selected")) {
			$("#sideMenu").fadeOut(200);
			$(this).removeClass("selected");
			$(".btnClose").removeClass("selected");
			$("#btnMenu .menuImg").fadeIn(200);
			$("#btnMenu .closeImg").hide();
		} else {
			$("html, body").animate({ scrollTop : 0 }); //if header not fixed -> comment out this line
			$("#sideMenu").fadeIn(200);
			$(this).addClass("selected");
			$(".btnClose").addClass("selected");
			$("#btnMenu .menuImg").hide();
			$("#btnMenu .closeImg").fadeIn(200);
		}
		return false;
	});
	
	$(".btnClose").click(function() {
		if ($(this).hasClass("selected")) {
			$("#sideMenu").fadeOut(200);
			$(this).removeClass("selected");
			$("#btnMenu").removeClass("selected");
			$("#btnMenu .menuImg").fadeIn(200);
			$("#btnMenu .closeImg").hide();
		} else {
			$("#sideMenu").fadeIn(200);
			$(this).addClass("selected");
			$("#btnMenu").addClass("selected");
			$("#btnMenu .menuImg").hide();
			$("#btnMenu .closeImg").fadeIn(200);
		}
		return false;
	});
	
});