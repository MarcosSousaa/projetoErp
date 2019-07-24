$(document).ready(function() {  
 
	// Quando o formulário for enviado, essa função é chamada
	$("#Logar").submit(function() {	
		if ($("#email").val()==''){
			$("#status").html("<font color=\"Red\">Favor Informe o Usuário</font>");
		//	alert("Favor Informe o Usuário");
			return false;
		}
		if ($("#usersenha").val()==''){
			$("#status").html("<font color=\"Red\">Favor Informe a senha</font>");
			//alert("Favor Informe a senha");
			return false;
		}
		var email = $("#email").val(), senha = $("#usersenha").val();
        $("#aguarde").html("<img src='imgs/loading.gif' alt='Entrando...' />").fadeIn("slow");
		

		// Fazemos a requisão ajax com o arquivo envia.php e enviamos os valores de cada campo através do método POST
		$.post('login.php', {email: email, senha: senha}, function(resposta) {
				// Quando terminada a requisição	           
				// Se a resposta é um erro
				if (resposta == 0) {
					// Exibe o erro na div					
					$("#status").html("<font color=\"Red\">Login ou Senha Inválidos</font>");
					$("#aguarde").fadeOut(3000);
					$("#status").fadeIn(3000);						
					$("#status").fadeOut(3000);
					$("#email").focus();
					$("#email").val("");
					$("#usersenha").val("");
				} 
				// Se resposta for false, ou seja, não ocorreu nenhum erro (Inverti Essa Parte)
				else {
					//Redireciona Para a Pagina de Administração
					window.location.href = 'emitente.php';
				}
		});
		return false;
	});
	
	
	
	$(".username").focus(function() {
		$(".user-icon").css("left","-48px");
	});
	$(".username").blur(function() {
		$(".user-icon").css("left","0px");
	});
	
	$(".password").focus(function() {
		$(".pass-icon").css("left","-48px");
	});
	$(".password").blur(function() {
		$(".pass-icon").css("left","0px");
	});
	
	
});

