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
		 $('#dados').load('produtos/listar.php');		  
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
			 $("#id").val("");	
			 $("#nome").val("");	
			 $("#unidade").val("");	
			 $("#estoque").val("");	
			 $("#ncm").val("");					  
	  		 $("#cest").val("");
			 $("#valor").val("");
			 $("#id").focus();			
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
			 if ($.trim($("#id").val()) == ''){
				$("#id").css({"border-color" : "#F00", "padding": "2px"});
				alert("Favor Informar o Código");
				$("#id").focus();
				return false;  
			  }
			  if ($.trim($("#nome").val()) == ''){
				$("#nome").css({"border-color" : "#F00", "padding": "2px"});
				alert("Favor Informar a Descrição");
				$("#nome").focus();
				return false;  
			  }
			  if ($.trim($("#ncm").val()) == ''){
				$("#ncm").css({"border-color" : "#F00", "padding": "2px"});
				alert("Favor Informar o NCM");
				$("#ncm").focus();
				return false;  
			  }
			   if ($.trim($("#un").val()) == ''){
				$("#un").css({"border-color" : "#F00", "padding": "2px"});
				alert("Favor Informar o UN");
				$("#un").focus();
				return false;  
			  }
			  
		   //Procedimentos para Incluir o Registro
		   $.post('produtos/salvar.php',{nome: $("#nome").val(), un: $("#un").val(), estoque: $("#estoque").val(), ncm: $("#ncm").val(), cest: $("#cest").val(), valor: $("#valor").val(), acao : acao, id: id}, function(resposta){
				alert(resposta);	
				$("#sucesso").dialog();		
                 $('#dados').load('produtos/listar.php');
				 $('#abandonar').click();
	          }) 
			
		 });
		 
		 //Se clicar em Alterar na Listagem
		 $('.botaoAlterar').live('click', function () {
			//Busco os dados do Cliente Selecionado   
			var idLinha = $(this).parent().parent().parent().attr('id');
	        var codigo  = $('#'+ idLinha).find('input:hidden').val(); 			
			id = codigo;     
			  $.getJSON('produtos/carregardados.php?codigo='+codigo, function(registro){					  
				  $("#id").val(registro.id);	
				  $("#nome").val(registro.nome);	
				  $("#un").val(registro.un);	
				  $("#estoque").val(registro.estoque);	
				  $("#ncm").val(registro.ncm);					  
	  		      $("#cest").val(registro.cest);
				  $("#valor").val(registro.valor);		  
					
	      	});  
			
			//Mudo para Aba Cadastro      
			 $("#tabs" ).tabs({beforeActivate: function( event, ui ) {}});
             $("#tabs").tabs( { active: 1 } );
			 $("#incluir").focus();			
		 });
		 
		 //Se clicar 2 vezes em cima da linha na Listagem
		 $('#grid1 tr').live('dblclick', function () {		
			//Busco os dados do Cliente Selecionado   
			var idLinha = $(this).attr('id');
	        var codigo  = $('#'+ idLinha).find('input:hidden').val();  			
			id = codigo;     
			  $.getJSON('produtos/carregardados.php?codigo='+codigo, function(registro){					  
				  $("#id").val(registro.id);	
				  $("#nome").val(registro.nome);	
				  $("#un").val(registro.un);	
				  $("#estoque").val(registro.estoque);	
				  $("#ncm").val(registro.ncm);					  
	  		      $("#cest").val(registro.cest);
				  $("#valor").val(registro.valor);		  
					
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
		$.post('produtos/excluir.php', {codigo: codigo}, function(resposta) {
				// Quando terminada a requisição
				//$("#aguarde2").fadeOut(100);	           
				// Mostro a Resposta em Um Alerta
				alert(resposta);
				$('#dados').load('produtos/listar.php'); 								
		
		});
		return false;
    }
		return false;

});
//Fim da Exclusão do Aluno
jQuery.noConflict();
jQuery(function($){
 //  $("#valor").mask("99.99");
     }); 
		 		 
	 
	}); 
	
	
</script>



<h2><img src="imgs/produtos.png" width="24" height="24" />Cadastro de Produtos</h2>
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
     <table width="515" border="0">
        <tr><td width="74">
          <p class="caption" id="lbl-razao">CÓDIGO*</p> 
          <input type="text" name="id" id="id" size="10" disabled="disabled" />
          </td>
          <td colspan="4">
            <p class="caption" id="lbl-nome">DESCRIÇÃO*</p> 
            <input type="text" name="nome" id="nome" size="46" disabled="disabled" />
            </td>
          
        </tr>
        
        <tr><td>
          <p class="caption" id="lbl-razao">ESTOQUE</p> 
          <input type="text" name="estoque" id="estoque" size="10" disabled="disabled" />
          </td>
          <td width="90">
            <p class="caption" id="lbl-nome">UN*</p> 
            <input type="text" name="un" id="un" size="15" disabled="disabled" />
            </td>
            <td width="90">
            <p class="caption" id="lbl-nome">VALOR*</p> 
            <input type="text" name="valor" id="valor" size="15" disabled="disabled" />
            </td>
          <td width="106">
            <p class="caption" id="lbl-nome">NCM</p> 
            <input type="text" name="ncm" id="ncm" size="15" disabled="disabled" />
            </td>
          <td width="243" colspan="2">
            <p class="caption" id="lbl-nome">CEST</p> 
            <input type="text" name="cest" id="cest" size="15" disabled="disabled" />
            </td>
           
        </tr>
        
       </table>       

    </div></form>
         
         
         
       </div>
    </div> 
 </div>

