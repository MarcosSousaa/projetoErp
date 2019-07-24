$(document).ready(function() { 
 
 //Salvar Novo Emitente
	$('#GravarEmitente').submit(function(e){
		e.preventDefault();
		
		$("input").css({"border" : "#C3C3C3 solid 1px"});
		$("#senha").css({"border" : "#C3C3C3 solid 1px"});
		$("#senha2").css({"border" : "#C3C3C3 solid 1px"});
		
		//Válida os Campos antes de Salvar a nova empresa
		if (!validarCNPJ($('#cnpj').val())){
		  $("#cnpj").css({"border" : "#F00 solid 2px"});
		  alert("CNPJ não é válido, favor verifique");	
		  $('#cnpj').focus();
		  return false;
		}
		if ($.trim($("#nome").val()) == ""){		  
		  alert("Favor Informar o Nome/Razão Social");
		  $("#nome").css({"border" : "#F00 solid 2px"});
		  $("#nome").focus();
				return false;  
		 }
			  
		 if ($.trim($("#cep").val()) == ''){
		  $("#cep").css({"border" : "#F00 solid 2px"});
		  alert("Favor Informar o CEP");
				$("#cep").focus();
				return false;  
			  }
			if ($.trim($("#endereco").val()) == ''){
		  $("#endereco").css({"border" : "#F00 solid 2px"});
		  alert("Favor Informar o Endereço");
				$("#cep").focus();
				return false;  
			  }
			   if ($.trim($("#numero").val()) == ''){
		  $("#numero").css({"border" : "#F00 solid 2px"});
		  alert("Favor Informar o Número");
				$("#numero").focus();
				return false;  
			  }
			  if ($.trim($("#bairro").val()) == ''){
		  $("#bairro").css({"border" : "#F00 solid 2px"});
		  alert("Favor Informar o Bairro");
				$("#bairro").focus();
				return false;  
			  }
		   if ($.trim($("#senha").val()) == ''){
		  $("#bairro").css({"border" : "#F00 solid 2px"});
		  alert("Favor Informar o Bairro");
				$("#bairro").focus();
				return false;  
			  }
			 
			 if ($.trim($("#senha").val()) != $.trim($("#senha2").val())){
		  $("#senha").css({"border" : "#F00 solid 2px"});
		  $("#senha2").css({"border" : "#F00 solid 2px"});
		  alert("A senha e a confirmação de senha não conferem! favor verifique");
				$("#senha").focus();
				return false;  
			  }
			  
		 if ($("#termo").is(":checked") == false){
			alert("Para continuar é Necessario Aceitar os termos de uso!");
			$("#termo").focus();
			return false;
		}

		
		$.post('emitente/salvar.php', $('#GravarEmitente').serialize(), function(resposta){
		$("#Formulario").html(resposta);
		//$('#GravarEmitente').prepend(resposta).find('label').fadeOut(3000, function(){$(this).remove();});
		//$('#GravarEmitente input[type=text]').removeClass('loading');
		//$('form')[0].reset();		
	})
   	  return false;
	})
	
	
	function validarCNPJ(cnpj) {
 
    cnpj = cnpj.replace(/[^\d]+/g,'');
 
    if(cnpj == '') return false;
     
    if (cnpj.length != 14)
        return false;
 
    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" || 
        cnpj == "11111111111111" || 
        cnpj == "22222222222222" || 
        cnpj == "33333333333333" || 
        cnpj == "44444444444444" || 
        cnpj == "55555555555555" || 
        cnpj == "66666666666666" || 
        cnpj == "77777777777777" || 
        cnpj == "88888888888888" || 
        cnpj == "99999999999999")
        return false;
         
    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0,tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;
         
    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
          return false;
           
    return true;
    
}
		 	

	
	
	});