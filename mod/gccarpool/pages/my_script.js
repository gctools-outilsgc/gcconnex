$("#submit").click(function(){

	$.post( $("#form").attr("action"), $("$#form : input").serializeArray(), function(info){
		$("#result").html(info);

	});
});
