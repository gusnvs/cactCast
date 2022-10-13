$(document).ready(function(){ // executamos este código apenas quando o documento estiver pronto

	$("#hidenLogin").click(function(){
		$("#login-form").hide();
		$("#register-form").show();
	});

	$("#hidenRegister").click(function(){
		$("#login-form").show();
		$("#register-form").hide();
	});
});