<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<link rel="stylesheet" href="includes/datatable/estilo/table_jui.css" />
<link rel="stylesheet" href="includes/datatable/estilo/jquery-ui-1.8.4.custom.css" />
 <script src="includes/jquery.js"></script>
 <script src="includes/jquery-ui.js"></script>
 <script type="text/javascript" src="includes/meiomask.js"></script>
<script> 
    $(document).ready(function() {	
		var
		  acao = '';
		  id   = '';		  
		 $('#dados').load('clientes/listar.php');		  
	     $( "#tabs" ).tabs(); 
		
   	   //Função que ativa ou Desativa os Botões
	     $('#incluir,#alterar').click(function(){
		     $('#incluir').prop('disabled', true);
			 $('#excluir').prop('disabled', true);
			 $('#alterar').prop('disabled', true);
			 $('#salvar').prop('disabled', false);
			 $('#abandonar').prop('disabled', false);
			 $('#Cadastro *').prop('disabled', false);
			// $('#cnpj').focus();
         });		 
		 
		 $('#abandonar').click(function(){
		     $('#incluir').prop('disabled', false);
			 $('#excluir').prop('disabled', false);
			 $('#alterar').prop('disabled', false);
			 $('#salvar').prop('disabled', true);
			 $('#abandonar').prop('disabled', true);
			 $('#Cadastro *').prop('disabled', true);
			 $("input:text").css({"border-color" : "#999", "padding": "2px"});
			 $("#grava")[0].reset();			 
         });
		 
		 $('#incluir').click(function(){
			 $("input:text").css({"border-color" : "#999", "padding": "2px"});
			 acao = 'I';			
		 });
		 $('#alterar').click(function(){
			 if($('#cnpj').val() == ""){
				alert('Nenhum Registro Selecionado para ser alterado');
				$('#abandonar').click();
				return false; 
			 }
			 acao = 'A';		
		 });
		 
		//Inserir Alterar registro 
		  $('#salvar').click(function(){
			  //Coloco o estilo padrão nos campos para ficar vermelho só o que não validou
			  $("input:text").css({"border-color" : "#999", "padding": "2px"});
			  //Validar os Campos			  
			 if ($.trim($("#cnpj").val()) == ''){
				$("#cnpj").css({"border-color" : "#F00", "padding": "2px"});
				alert("Favor Informar o CNPJ");
				$("#cnpj").focus();
				return false;  
			  }
			  if ($.trim($("#nome").val()) == ''){
				$("#nome").css({"border-color" : "#F00", "padding": "2px"});
				alert("Favor Informar o Nome/Razão Social");
				$("#nome").focus();
				return false;  
			  }
			  if ($.trim($("#cep").val()) == ''){
				$("#cep").css({"border-color" : "#F00", "padding": "2px"});
				alert("Favor Informar o CEP");
				$("#cep").focus();
				return false;  
			  }
			   if ($.trim($("#endereco").val()) == ''){
				$("#endereco").css({"border-color" : "#F00", "padding": "2px"});
				alert("Favor Informar o Endereço");
				$("#endereco").focus();
				return false;  
			  }
			  
		   //Procedimentos para Incluir o Registro
		   $.post('clientes/salvar.php',{pessoa: $("#pessoa:checked").val(), cnpj: $("#cnpj").val(), tipo_ie : $("#tipo_ie option:selected").val(), ie: $("#ie").val(), nome: $("#nome").val(), fantasia: $("#fantasia").val(), telefone: $("#telefone").val(), cep: $("#cep").val(), endereco: $("#endereco").val(), numero: $("#numero").val(), bairro: $("#bairro").val(), complemento: $("#complemento").val(), estado: $("#estado option:selected").text(), codigo_estado: $("#estado option:selected").val(), cidade: $("#cidade option:selected").text(), codigo_cidade: $("#cidade option:selected").val(), email: $("#email").val(), acao : acao, id: id}, function(resposta){
				alert(resposta);	
			//	$("#sucesso").dialog();		
                 $('#dados').load('clientes/listar.php');
				 $('#abandonar').click();
	          }) 
			
		 });
		 
		 //Se clicar em Alterar na Listagem
		 $('.botaoAlterar').live('click', function () {
			//Busco os dados do Cliente Selecionado   
			var idLinha = $(this).parent().parent().parent().attr('id');
	        var codigo  = $('#'+ idLinha).find('input:hidden').val(); 			
			id = codigo;     
			  $.getJSON('clientes/carregardados.php?codigo='+codigo, function(registro){					  
				  if (registro.pessoa == 'F'){
					$(".pessoaF").prop("checked", true);  
				  }else{					
					$(".pessoaJ").prop("checked", true);  
				  }		
				  //Busco as Cidades
				  $('#estado option[value="' + registro.codigo_estado + '"]').attr({ selected : "selected" });
				  $.post("includes/cidades.php",{estado:registro.codigo_estado},function(valor){
                     $("select[name=cidade]").html(valor);
					 $('#cidade option[value="' + registro.codigo_cidade + '"]').attr({ selected : "selected" });
                  }	)
				  
				  $('#tipo_ie option[value="' + registro.tipo_ie + '"]').attr({ selected : "selected" });
				  $("#nome").val(registro.nome);
				  $("#cnpj").val(registro.cpf_cnpj);
				  //$("#tipo_ie").val(registro.tipo_ie);
				  $("#ie").val(registro.ie);
				  $("#telefone").val(registro.telefone);
				  $("#fantasia").val(registro.fantasia);
				  $("#cep").val(registro.cep);	
				  $("#endereco").val(registro.endereco);	
				  $("#numero").val(registro.numero);	
				  $("#bairro").val(registro.bairro);	
				  $("#complemento").val(registro.complemento);					  
	  		      $("#email").val(registro.email);
				  
					
	      	});  
			
			//Mudo para Aba Cadastro      
			 $("#tabs" ).tabs({beforeActivate: function( event, ui ) {}});
             $("#tabs").tabs( { active: 1 } );
			 $("#incluir").focus();			
		 });
		 
		 
		 //Se clicar em Alterar na Listagem
		 $('#grid1 tr').live('dblclick', function () {
			//Busco os dados do Cliente Selecionado   
			var idLinha = $(this).attr('id');
	        var codigo  = $('#'+ idLinha).find('input:hidden').val();  			
			id = codigo;     
			  $.getJSON('clientes/carregardados.php?codigo='+codigo, function(registro){					  
				  if (registro.pessoa == 'F'){
					$(".pessoaF").prop("checked", true);  
				  }else{					
					$(".pessoaJ").prop("checked", true);  
				  }		
				  //Busco as Cidades
				  $('#estado option[value="' + registro.codigo_estado + '"]').attr({ selected : "selected" });
				  $.post("includes/cidades.php",{estado:registro.codigo_estado},function(valor){
                     $("select[name=cidade]").html(valor);
					 $('#cidade option[value="' + registro.codigo_cidade + '"]').attr({ selected : "selected" });
                  }	)
				  
				  $('#tipo_ie option[value="' + registro.tipo_ie + '"]').attr({ selected : "selected" });
				  $("#nome").val(registro.nome);
				  $("#cnpj").val(registro.cpf_cnpj);
				  //$("#tipo_ie").val(registro.tipo_ie);
				  $("#ie").val(registro.ie);
				  $("#telefone").val(registro.telefone);
				  $("#fantasia").val(registro.fantasia);
				  $("#cep").val(registro.cep);	
				  $("#endereco").val(registro.endereco);	
				  $("#numero").val(registro.numero);	
				  $("#bairro").val(registro.bairro);	
				  $("#complemento").val(registro.complemento);					  
	  		      $("#email").val(registro.email);
				  
					
	      	});  
			
			//Mudo para Aba Cadastro      
			 $("#tabs" ).tabs({beforeActivate: function( event, ui ) {}});
             $("#tabs").tabs( { active: 1 } );
			 $("#incluir").focus();			
		 });
		 
		 
		 
		//Apagar Registro 
$('.botaoExcluir').live('click', function () {	
 if( confirm('Deseja excluir?') ){
    var idLinha = $(this).parent().parent().parent().attr('id');
	var codigo  = $('#'+ idLinha).find('input:hidden').val();	
	// Exibe mensagem de carregamento
	//$("#aguarde2").html("<img src='images/loader.gif' alt='Entrando...' />").fadeIn("slow");
		$.post('clientes/excluir.php', {codigo: codigo}, function(resposta) {
				// Quando terminada a requisição
				//$("#aguarde2").fadeOut(100);	           
				// Mostro a Resposta em Um Alerta
				alert(resposta);
				$('#dados').load('clientes/listar.php'); 								
		
		});
		return false;
    }
		return false;

});
//Fim da Exclusão do Aluno
/*
jQuery.noConflict();
jQuery(function($){
   $("#data").mask("99/99/9999");
   $("#telefone").mask("(099) 9999-9999");
   $("#cep").mask("99999-999");   
   $("#placa").mask("aaa - 9999");
   $("#cnpj").mask("99.999.999/9999-99"); 
        $('.pessoaF, .pessoaJ').click(function(){     
		       if ($("#pessoa:checked").val() == "F"){ 			               
                   $("#cnpj").mask("999.999.999-99");
				   $("#lbl-cpf").text('CPF');
				   $("#lbl-razao").text('NOME');
				   $("#fantasia").val("");
				   $('#fantasia').prop('disabled', true);
				   $("#cnpj").focus();
                }else{
				   $("#cnpj").mask("99.999.999/9999-99");
				   $("#lbl-cpf").text('CNPJ');
				   $("#lbl-razao").text('RAZÃO SOCIAL');
				   $('#fantasia').prop('disabled', false);
				   $("#cnpj").focus();
                }
});
            }); 
		 */
		 
		 
		  $("select[name=estado]").change(function(){
            $("select[name=cidade]").html('<option value="0">Carregando...</option>');
            
            $.post("includes/cidades.php", 
                  {estado:$(this).val()},
                  function(valor){
                     $("select[name=cidade]").html(valor);
                  }
                  )
            
         })	 
		 
		   
		 
	 
	}); 
	
	
</script>



<h2><img src="imgs/clientes.png" width="24" height="24" />Cadastro de Clientes</h2>
  <div id="tabs">
    <ul> 
      <li><a href="#aba-1">Pesquisa</a></li>
      <li><a href="#aba-2">Cadastro</a></li>
    </ul> 
      
    <div id="aba-1"> 
    
       
    <div id="dados">   
     <!-- Aqui Listo os dados Cadastrados -->
    </div>

    </div> 
    <div id="aba-2"> 
    
      <div id="Botoes">
         <input type="button" id="incluir" value="Incluir" class="but" /> 
         <input type="button" id="excluir" value="Excluir" class="but" />
         <input type="button" id="alterar" value="Alterar" class="but" />
         <input type="button" id="salvar" value="Salvar" disabled="disabled" class="but" />
         <input type="button" id="abandonar" value="Abandonar" disabled="disabled" class="but" />
       </div>
       <div id="Cadastro">
    <div id="Formulario">
    <form method="post" action="" id="grava">
     <table border="0">        
        <tr>
        <td><p class="caption" id="lbl-nome">PESSOA *</p>
          <input type="radio" name="pessoa" id="pessoa" value="F" class="pessoaF" disabled="disabled" />FÍSICA
          <input type="radio" name="pessoa" id="pessoa" value="J" checked="checked" class="pessoaJ" disabled="disabled" />JURÍDICA
          </td>
        <td>
          <p class="caption" id="lbl-cpf">CNPJ *</p>
          <input type="text" name="cnpj" id="cnpj" size="26" disabled="disabled" /></td>
        
        <td><p class="caption" id="lbl-nome">Tipo IE *</p>
          <select name="tipo_ie" id="tipo_ie" disabled="disabled">
            <option value="0">Contribuinte</option>
            <option value="1">Não Contribuinte</option>
            <option value="9">Isento</option>
          </select>
          </td>
        
         <td>
          <p class="caption" id="lbl-nome">INSCRIÇÃO ESTADUAL</p>
          <input type="text" name="ie" id="ie" disabled="disabled" /></td> 
          
          </tr>
        <tr><td colspan="2">
          <p class="caption" id="lbl-razao">RAZÃO SOCIAL *</p> 
          <input type="text" name="nome" id="nome" size="46" disabled="disabled" />
        </td>
        <td>
          <p class="caption" id="lbl-nome">Nome Fantasia</p> 
          <input type="text" name="fantasia" id="fantasia" size="20" disabled="disabled" />
        </td>
        <td>
          <p class="caption" id="lbl-nome">Telefone</p> 
          <input type="text" name="telefone" id="telefone" size="15" disabled="disabled" />
        </td>
        </tr>
        <tr>
           <td>
            <p class="caption" id="lbl-nome">CEP *</p>
            <input type="text" name="cep"  id="cep" size="15" alt="cep" disabled="disabled" /> 
           </td>
           <td>
            <p class="caption" id="lbl-nome">Endereço *</p>
            <input type="text" name="endereco" id="endereco" size="26" disabled="disabled" /> 
           </td>
           <td>
            <p class="caption" id="lbl-nome">Número *</p>
            <input type="text" name="numero" id="numero" size="6" disabled="disabled" />
            </td></tr>
          <tr><td colspan="2">
                <p class="caption" id="lbl-nome">Bairro *</p> <input type="text" name="bairro" id="bairro" size="45" disabled="disabled" />
              </td> 
              <td>
                <p class="caption" id="lbl-nome">Complemento</p> <input type="text" name="complemento" id="complemento" size="20" disabled="disabled" />               
          </td></tr>
          <tr><td>
          <p class="caption" id="lbl-nome">Estado *</p>
            <select name="estado" id="estado" class="CadCli" disabled="disabled">
                           <option value="0">Escolha um Estado</option>
                           <?php
						   $estados = mysqli_query($conexao,"select distinct codigo_estado,  sigla_estado from cidades order by sigla_estado ASC");
						   while ($lista_estados = mysqli_fetch_array($estados)){
							   echo "<option value=\"".$lista_estados["codigo_estado"]."\">".$lista_estados["sigla_estado"]."</option>";
							   
						   } 
						   ?>
                           </select> </td>
            <td>  
              <p class="caption" id="lbl-nome">Cidade *</p>
              <select name="cidade" id="cidade" class="CadCli" disabled="disabled">
                               <option value="0" disabled="disabled">Escolha um Estado Primeiro</option>
                             </select>
          </td>
         <td colspan="2">
                <p class="caption" id="lbl-nome">EMAIL</p> <input type="text" name="email" id="email" size="40" disabled="disabled" />               
          </td>
          </tr>
          <tr>
            <td> <p class="caption" id="lbl-nome">PAÍS</p>
             <select name="pais" id="pais" class="CadCli" disabled="disabled">
              <option value="0">BRASIL</option>
             </select>
            </td>
            <td>
            <p class="caption" id="lbl-nome">INSCRIÇÃO MUNICIPAL</p>
            <input type="text" name="im" id="im" size="20" disabled="disabled" />
            </td>
             <td>
               <p class="caption" id="lbl-nome">CNAE</p>
              <input type="text" name="cnae" id="cnae" size="20" disabled="disabled" />
             </td>
            </tr>
       </table>       

    </div></form>
         
         
         
       </div>
    </div> 
 </div>

