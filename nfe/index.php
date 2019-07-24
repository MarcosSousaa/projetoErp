<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<link rel="stylesheet" href="includes/datatable/estilo/table_jui.css" />
<link rel="stylesheet" href="includes/datatable/estilo/jquery-ui-1.8.4.custom.css" />
<script type="text/javascript">
$(document).ready(function() {	

function getMoney( str )
{
        return parseInt( str.replace(/[\D]+/g,'') );
}

 function formatReal( int )
{
        var tmp = int+'';
        var neg = false;
        if(tmp.indexOf("-") == 0)
        {
            neg = true;
            tmp = tmp.replace("-","");
        }
        
        if(tmp.length == 1) tmp = "0"+tmp
    
        tmp = tmp.replace(/([0-9]{2})$/g, ",$1");
        if( tmp.length > 6)
            tmp = tmp.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
        
        if( tmp.length > 9)
            tmp = tmp.replace(/([0-9]{3}).([0-9]{3}),([0-9]{2}$)/g,".$1.$2,$3");
    
        if( tmp.length > 12)
            tmp = tmp.replace(/([0-9]{3}).([0-9]{3}).([0-9]{3}),([0-9]{2}$)/g,".$1.$2.$3,$4");
        
        if(tmp.indexOf(".") == 0) tmp = tmp.replace(".","");
        if(tmp.indexOf(",") == 0) tmp = tmp.replace(",","0,");
    
    return (neg ? '-'+tmp : tmp);
}

		 //Atualiza os Valores da Nota
        function CalculaValores(numero_nota){
	   var
		numero_nota         = numero_nota;
		totalFrete          = getMoney($('#total_frete').val());	
		totalDesconto       = getMoney($('#total_desconto').val());
		totalNota           = 0;
		$.getJSON('nfe/atualizavalores.php?id='+numero_nota, function(resposta){
			//Soma Total dos Produtos	
			totalProdutos = getMoney(resposta[0]);
			totalNota     = formatReal(totalProdutos + totalFrete - totalDesconto);
			
			//Calcula o Frete se Houver
			if ( ($('#total_frete').val() != '') || ($('#total_frete').val() != '0') ){
		     $('#total_nota').val(formatReal(totalProdutos+totalFrete-totalDesconto));
		    }
			
			//Calcula o Desconto se Houver
			 if (totalDesconto > totalProdutos){
			    $('#total_desconto').val('0,00')
			    alert("Valor do desconto não pode ser maior que a soma dos produtos da nota");
			    $('#total_desconto').focus();
			    return false;
		     }
		   if ( ($('#total_desconto').val() != '') || ($('#total_desconto').val() != '0') ){
		     $('#total_nota').val(formatReal(totalProdutos+totalFrete-totalDesconto));
		   }
		    
			$('#total_produtos').val(formatReal(totalProdutos));
			$('#total_nota').val(totalNota); 			
		  });
		 }


   //Abrir Form Modal
	$('a[name=modal]').click(function(e) {
		e.preventDefault();
		
		var id = $(this).attr('href');
	
		var maskHeight = $(document).height();//$(window).height();
		var maskWidth = $(document).width();
	
		$('#mask').css({'width':maskWidth,'height':maskHeight});

		$('#mask').fadeIn(1000);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(document).height();
		var winW = $(document).width();
              
		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
	
		$(id).fadeIn(2000); 
	
	});
	
	$('.window .close').click(function (e) {
		e.preventDefault();
		
		$('#mask').hide();
		$('.window').hide();
	});		
	
	
	
	//Mudo a Aba quando der dois cliques em uma das linhas da tabela
	$('#grid1 tr').live('dblclick', function () {
		//Busco os dados da Nota Selecionada   
			var idLinha = $(this).attr('id');
	        var codigo  = $('#'+ idLinha).find('input:hidden').val(); 			
   
			  $.getJSON('nfe/carregardados.php?codigo='+codigo, function(registro){						  
				  //$('#tipo_ie option[value="' + registro.tipo_ie + '"]').attr({ selected : "selected" });
				  $("#id_nota").val(codigo);
				  $("#numero").val(registro.id);				  
				  $("#emissao").val(registro.emissao);
				  $("#saida").val(registro.saida);
				  $("#id_cliente").val(registro.id_cliente);
				  $("#nome_cliente").val(registro.nome_cliente);
				  $("#natureza").val(registro.natureza);
				  $("#inf_ad_contribuinte").val(registro.inf_ad_contribuinte);	
				  $("#inf_ad_fisco").val(registro.inf_ad_fisco);	
				  $("#total_produtos").val(formatReal(getMoney(registro.valor_produtos)));
				  $("#total_desconto").val(formatReal(getMoney(registro.desconto)));
				  $("#total_frete").val(formatReal(getMoney(registro.valor_frete)));
				  $("#total_nota").val(formatReal(getMoney(registro.valor_total)));
				  //Carrego os dados dos campos do tipo Select	
				  $('#finalidade option[value="' + registro.finalidade + '"]').attr({ selected : "selected" });	
				  $('#modFrete option[value="' + registro.frete + '"]').attr({ selected : "selected" });	
				  $('#formapagto option[value="' + registro.formapagto + '"]').attr({ selected : "selected" });	
				  
				  
				   //Ajusto os Botões de Acordo com a Situação da NFe selecionada se estiver transmitida ou cancelada desativo os botões
			 $.get('nfe/situacao.php?id='+codigo, function(retorno){
			  if (retorno == 0){ // 0=Cancelada
			    $('#incluir').prop('disabled', true);
			    $('#excluir').prop('disabled', true); //Cancelar
			    $('#alterar').prop('disabled', true);
			    $('#btnsalvarNFe1').prop('disabled', true);
			    $('#btnTransmitir').prop('disabled', true);
			    $('#Cadastro *').prop('disabled', true);
			  }else if (retorno == 1){ // 1=Transmitida
				$('#incluir').prop('disabled', true);
			    $('#excluir').prop('disabled', false); //Cancelar
			    $('#alterar').prop('disabled', true);
			    $('#btnsalvarNFe1').prop('disabled', true);
			    $('#btnTransmitir').prop('disabled', true);
			    $('#Cadastro *').prop('disabled', false);  
			  }
				  			
	      	});  
			
			//Mudo para Aba Cadastro      
			 $("#tabs" ).tabs({beforeActivate: function( event, ui ) {}});
             $("#tabs").tabs( { active: 1 } );			
			 $("#incluir").focus();	
					  
	  });
			 
	});
	
	
	//Pego o Valor da Pesquisa e jogo nos campos
	$('.tabelaPesquisa').live('dblclick', function () {
		var idProduto = $(this).closest('tr').find('td[data-id]').data('id');
		var nome = $(this).closest('tr').find('td[data-nome]').data('nome');		
		$('.window').hide();
		$('#mask').hide();
		
		CarregaPesquisaProduto(idProduto);
		$("#codigo_produto").val(idProduto);
		$("#nome_produto").val(nome);
		$(".input-search").val("");
		$('#ResultadoPesquisa').html("Nenhum Registro Encontrado")
		//$('#ResultadoPesquisa').fadeOut("slow");		
	});	
	
	//Pego o Valor da Pesquisa de clientes e jogo nos campos
	$('.tabelaPesquisaClientes').live('dblclick', function () {
		var idCliente = $(this).closest('tr').find('td[data-id]').data('id');
		//var nome = $(this).closest('tr').find('td[data-nome]').data('nome');
		CarregaPesquisaCliente(idCliente);		
		$('.window').hide();
		$('#mask').hide();
		
		
		$(".input-search2").val("");
		$('#ResultadoPesquisaclientes').html("Nenhum Registro Encontrado")
		//$('#ResultadoPesquisa').fadeOut("slow");	
	});	
	
	//Faço a Pesquisa de produtos em tempo real porque eu sou foda!
	$(".input-search").keyup(function(){
		var valor = $(this).val();		
			$.get('includes/pesquisaResultado.php?busca='+valor, function(retorno){
			  $('#ResultadoPesquisa').html(retorno);
			  $('#ResultadoPesquisa').fadeIn("slow");			  
	  });
	});
	
	//Faço a Pesquisa de produtos em tempo real porque eu sou foda!
	$(".input-search2").keyup(function(){
		var valor = $(this).val();		
			$.get('includes/pesquisaClientesResultado.php?busca='+valor, function(retorno){
			  $('#ResultadoPesquisaclientes').html(retorno);
			  $('#ResultadoPesquisaclientes').fadeIn("slow");			  
	  });
	});
	
	
	 //Faz a Inclusao de Itens na Nota
		 $('#codigo_produto').blur(function(){
		   CarregaPesquisaProduto( $('#codigo_produto').val() );		
		 });
		 
		  //Faz a Inclusao de Clientes na nota quando digita o Código no Campo
		 $('#id_cliente').blur(function(){
		   CarregaPesquisaCliente( $('#id_cliente').val() );
		   return false;		
		 });	
		 
		  //Calcula o Valor total com a Qtd
		 $('#qtd').blur(function(){ 
		 var
		  qtd = getMoney($('#qtd').val()) ; 
		  valor_un = getMoney( $('#valor_un').val() );
		  if ( ($('#valor_un').val() != '') || ($('#valor_un').val() != '0') ){
		     $('#valor_total').val(formatReal(qtd*valor_un));
		  }
		   return false;		
		 }); 
		 
		  //Calcula o Valor total com a Qtd
		 $('#valor_un').blur(function(){ 
		 var
		  qtd = getMoney($('#qtd').val()) ; 
		  valor_un = getMoney( $('#valor_un').val() );
		  if ( ($('#qtd').val() != '') || ($('#qtd').val() != '0') ){
		     $('#valor_total').val(formatReal(qtd*valor_un));
		  }
		   return false;		
		 }); 
		 
		 //Calcula o Valor total da nota de acordo com o Total dos produtos, o total do desconto e o frete
		 $('#total_frete').blur(function(){ 
		   numero_nota = $("#id_nota").val();
	       CalculaValores(numero_nota);		  
		   return false;		
		 }); 
		 	
		  $('#total_desconto').blur(function(){ 
		   numero_nota = $("#id_nota").val();
           CalculaValores(numero_nota);		 
		   return false;		
		 });  
		
		
		//Insere Produtos na Grid de produtos da Nota
		 $('#btnInserirItem').click(function(){
		 var		   
		   numero_nota = $("#id_nota").val();
 		   codigo_produto = $("#codigo_produto").val();
		   nome = $("#nome_produto").val();
		   qtd = $("#qtd").val();
		   ncm = $("#ncm").val();
		   valor_un = $("#valor_un").val();
		   valor_total = $("#valor_total").val();		   
		 $.post("nfe/insereitem.php",{codigo_produto:codigo_produto, numero_nota:numero_nota, nome:nome, qtd:qtd, valor_un:valor_un, valor_total:valor_total, ncm:ncm},function(resposta){
			// alert(resposta);
			         CalculaValores(numero_nota);
			         $("#codigo_produto").val("");
					 $("#nome_produto").val("");
					 $("#qtd").val("");
					 $("#valor_un").val("");
					 $("#valor_total").val("");
					 $("#ncm").val("");
                     $('#listaItens').load('nfe/itensnota.php?id='+numero_nota);
					 $("#codigo_produto").focus();
                  }	)
		 }) 
		 
		 //Enviar XML e PDF por email
		 $('#btnEnviaEmail').click(function(){ 
		  var 
		     email = prompt("Informe o Email para o qual deseja enviar a NFe", "Iforme o Email");
		     numero_nota = $("#id_nota").val();
          $.post("nfe/EnviaNfeEmail.php",{numero_nota:numero_nota, email:email},function(resposta){
			 alert(resposta);
		  }	) 		 
		   return false;		
		 });  
		

		 
		 function CarregaPesquisaProduto(codigo_produto){
			 var
			   codigo = codigo_produto;//$('#codigo_produto').val();		   
			   
			   // Exibe mensagem de carregamento
		      $("#aguarde").html("<img src='imgs/loader.gif' alt='Aguarde...' />").fadeIn("slow");
			   
			 if(codigo != ''){
			   $.getJSON('nfe/buscaprod_porcod.php?codigo_produto='+codigo, function(resposta){
				 var
				   valorFormatado = 0;
			   if (resposta == 0){
			 	 alert("Produto Não encontrado!");
				 $('#codigo_produto').val("");
				 $('#codigo_produto').focus();
				 $("#aguarde").hide();
		 	     return false;
			   }else{
				 valorFormatado = getMoney(resposta[1]);
				// alert(formatReal(valorFormatado)); 
			     $('#nome_produto').val(resposta[0]);	
				 $('#valor_un').val(formatReal(valorFormatado));
				 $('#qtd').val("1");
				 $('#valor_total').val(formatReal(valorFormatado));
				 $('#ncm').val(resposta[3]);
			     $('#btnAddItem').focus();
			   }
			 });
		   }		   
		   $("#aguarde").hide(); 
		 }
		 
				 
		 function CarregaPesquisaCliente(codigo_cliente){
			 var
			   codigo = codigo_cliente;//$('#codigo_produto').val();		  
							
			 if(codigo != ''){
				 try{
			 // Exibe mensagem de carregamento
		      $("#aguarde2").html("<img src='imgs/loader.gif' alt='Aguarde...' />").fadeIn("slow");
			   $.getJSON('nfe/buscacli_porcod.php?codigo_cliente='+codigo, function(resposta){
			     if (resposta == 0){			  	   
			 	   alert("Cliente Não encontrado!");
				   $('#id_cliente').val("");
				   $('#id_cliente').focus();		 	      
			     }else{
				   $('#id_cliente').val(resposta[0]);	
			       $('#nome_cliente').val(resposta[1]);					   
				   $('#btnsalvarNFe1').focus();
				 }			   
			 });
				 }finally{
				   $("#aguarde2").hide();				   				   	 
				 }
				 
		   }
		  
		 }
		  
		
	
		 	
	});	
</script>
<style type="text/css">
#mask {
  position:fixed;
  left:0;
  top:0;
  z-index:9000;
  background-color:#000;
  display:none;
}
  
#boxes .window {
  position:fixed;
  left:-100;
  top:0;
  width:440px;
  height:auto;
  display:none;
  z-index:9999;
  padding:20px;  
}

#boxes #dialog {
  width:500px; 
  height:auto;
  padding:10px;
  background-color:#ffffff;
  border-radius:10px;
}

#boxes #dialog2 {
  width:500px; 
  height:auto;
  padding:10px;
  background-color:#ffffff;
  border-radius: 10px;
}


#boxes #dialog1 {
  width:375px; 
  height:auto;
  border-radius:10px;
}


#dialog1 .d-header {
  background:url(login-header.png) no-repeat 0 0 transparent; 
  width:375px; 
  height:150px;
}

#dialog1 .d-header input {
  position:relative;
  top:60px;
  left:100px;
  border:3px solid #cccccc;
  height:22px;
  width:200px;
  font-size:15px;
  padding:5px;
  margin-top:4px;
}
.close{ text-align:right;}

</style>
 <script src="includes/jquery.js"></script>
 <script src="includes/jquery-ui.js"></script>
 <script type="text/javascript" src="includes/meiomask.js"></script>
 <script type="text/javascript">
          (function($){
	      $(
		function(){
			$('input:text').setMask();
		}
	  );
          })(jQuery);
      </script>
<script> 
    $(document).ready(function() {	
		var
		  acao = '';
		//  id   = '';		  
		 $('#dados').load('nfe/listar.php');	
		 $('#listaItens').load('nfe/itensnota.php');	  
	     $( "#tabs" ).tabs(); 
		 $( "#tabs2" ).tabs(); 	 
		  	
		 	 
		
		
   	   //Função que ativa ou Desativa os Botões
	     $('#NovaNota,#alterar').click(function(){
		     $('#incluir').prop('disabled', true);
			 $('#excluir').prop('disabled', true);
			 $('#alterar').prop('disabled', true);
			 $('#btnsalvarNFe1').prop('disabled', false);
			 $('#btnTransmitir').prop('disabled', false);
			 $('#Cadastro *').prop('disabled', false);
			// $('#cnpj').focus();
         });		 
		 
		 $('#btnTransmitir').click(function(){
		     $('#incluir').prop('disabled', false);
			 $('#excluir').prop('disabled', false);
			 $('#alterar').prop('disabled', false);
			 $('#btnsalvarNFe1').prop('disabled', true);
			 $('#btnTransmitir').prop('disabled', true);
			 $('#Cadastro *').prop('disabled', true);
			 $("input:text").css({"border-color" : "#999", "padding": "2px"});			 			 
         });
		 
		 $('#incluir').click(function(){
			 $("input:text").css({"border-color" : "#999", "padding": "2px"});
			 acao = 'I';			
		 });
		 $('#alterar').click(function(){
			 if($('#cnpj').val() == ""){
				alert('Nenhum Registro Selecionado para ser alterado');
				$('#btnTransmitir').click();
				return false; 
			 }
			 acao = 'A';		
		 });
		 
		 //Botão que Transmite a NFe		 
		  $('#btnTransmitir').click(function() {
			  numero_nota         = $("#numero").val();
			   $.post('nfe/transmitir.php', {numero_nota:numero_nota}, function(resposta){
				  alert(resposta); 
				  $('#dados').load('nfe/listar.php'); 
				  $("#grava")[0].reset(); //Limpa os dados 
			   })
		  });
		  
		  //Botão que Imprime o Danfe a NFe		 
		  $('#btnImprimir').click(function() {
			  numero_nota         = $("#numero").val();
			  window.open("nfe/ImprimirDanfe.php?numero_nota="+numero_nota);
			  // $.post('nfe/ImprimirDanfe.php', {numero_nota:numero_nota}, function(resposta){
				 // alert(resposta);
					 //window.open(resposta);
			 //  })
		  });
		  
		  //Botão que Cancela a NFe		 
		  $('#excluir').click(function() {
			 numero_nota         = $("#numero").val();
			 var motivoCancelamento = prompt ("Informe o Motivo do Canclamento da Nfe");
			 		
              if (motivoCancelamento.length < 15){
                 alert ("O Motivo do Cancelamento deve possuir mais que 15 Caracteres");
				 return false; 
			  }
			  
			   $.post('nfe/cancelarNfe.php', {numero_nota:numero_nota, motivoCancelamento:motivoCancelamento}, function(resposta){
				  alert(resposta); 
				  $('#dados').load('nfe/listar.php');  
				  $("#grava")[0].reset(); //Limpa os dados 
			   })
		  });
		  
		  //Botão Consultar NFe na Sefaz 
		  $('#ConsultaNfe').click(function() {
			  numero_nota         = $("#numero").val();
			   $.post('nfe/ConsultaChaveNFe.php', {numero_nota:numero_nota}, function(resposta){
				  alert(resposta);   
			   })
		  });
		 
		//Inserir Alterar registro 		
		  $('#btnsalvarNFe1').click(function() {
			  id_nota             = $("#id_nota").val();
			  numero_nota         = $("#numero").val();			  
 		      emissao             = $("#emissao").val();
			  saida               = $("#saida").val();
			  natureza            = $("#natureza").val();
			  id_cliente          = $("#id_cliente").val();
			  nome_cliente        = $("#nome_cliente").val();
			  inf_ad_contribuinte = $("#inf_ad_contribuinte").val();
			  inf_ad_fisco        = $("#inf_ad_fisco").val();
			  finalidade          = $("#finalidade").val();
			  formapagto          = $("#formapagto").val();
			  modFrete            = $("#modFrete").val();
			  //Calculo os Valores antes de gravar nas variaveis
			  //CalculaValores();
			  desconto            = $("#total_desconto").val();
			  frete               = $("#total_frete").val();
			  totalprodutos       = $("#total_produtos").val();
			  totalnfe            = $("#total_nota").val();
			  
			  
			  //Coloco o estilo padrão nos campos para ficar vermelho só o que não validou	  
			  $("input:text").css({"border-color" : "#999", "padding": "2px"});
			  
			  //Validar os Campos	
			  if ($("#numero").val()==""){
				  $("#numero").css({"border-color" : "#ED2327", "padding": "2px"});
				  alert("Número da Nota não Informado!");
				  $("#numero").focus();
				  return false;
			  }
			  if ($("#emissao").val()==""){
				  $("#emissao").css({"border-color" : "#ED2327", "padding": "2px"});
				  alert("data de Emissão não Informada!");
				  $("#emissao").focus();
				  return false;
			  }
			  if ($("#saida").val()==""){
				  $("#saida").css({"border-color" : "#ED2327", "padding": "2px"});
				  alert("data de Saída não Informada!");
				  $("#saida").focus();
				  return false;
			  }
			  if ($("#natureza").val()==""){
				  $("#natureza").css({"border-color" : "#ED2327", "padding": "2px"});
				  alert("data de Saída não Informada!");
				  $("#natureza").focus();
				  return false;
			  }
			  if ($("#id_cliente").val()==""){
				  $("#id_cliente").css({"border-color" : "#ED2327", "padding": "2px"});
				  alert("Cliente não Informado!");				  
				  $("#id_cliente").focus();
				  return false;
			  }
			  	
			 $('#incluir').prop('disabled', false);
			 $('#excluir').prop('disabled', false);
			 $('#alterar').prop('disabled', false);
			 $('#btnsalvarNFe1').prop('disabled', true);
			 $('#btnTransmitir').prop('disabled', false);
			 $('#Cadastro *').prop('disabled', true);
			 $("input:text").css({"border-color" : "#999", "padding": "2px"});	  
			            
  		//Procedimentos para Incluir o Registro
		   $.post('nfe/salvar.php', {id_nota:id_nota, numero_nota:numero_nota, emissao:emissao, saida:saida,natureza:natureza, id_cliente:id_cliente, nome_cliente:nome_cliente,inf_ad_contribuinte:inf_ad_contribuinte, inf_ad_fisco:inf_ad_fisco, finalidade:finalidade, formapagto:formapagto, modFrete:modFrete, desconto:desconto, frete:frete, totalprodutos:totalprodutos, totalnfe:totalnfe, acao:acao}, function(resposta){
				//alert(resposta);	
				if (resposta == 0){
				  if (acao = 'I'){
				   // alert("Nota Fiscal Gravada com Sucesso");	
				    mensagem = "Gravada";
				  }else{
					//alert("Dados da Nota Fiscal Atualizados"); 
					mensagem = "Atualizada"; 
				  }
				  
				  //Procedimentos para Gerar a NFe
		       //   $.post('nfe/gerarnfe.php',{numero_nota:numero_nota}, function(resposta){
				  $.post('nfe/gerarnfe.php',{numero_nota:numero_nota}, function(nfe){
					  mensagem = mensagem + ", Gerada";
					  //alert(nfe);					  
					   //Procedimentos para Assinar a NFe
				       $.post('nfe/AssinaNFe.php',{numero_nota:numero_nota}, function(nfe){
						mensagem = mensagem + " e Assinada";
					   alert("Nota "+ mensagem + " com sucesso");		    	   
				  // $('#btnTransmitir').click();
	             })  
					  
		    	   $('#dados').load('nfe/listar.php');
				  // $('#btnTransmitir').click();
	             }) 
				 
				
				  
				}else{
					alert(resposta);
				  //alert("Não foi possivel atualizar os dados da NFe, Favor tente novamente mais tarde");	
				}
                // $('#dados').load('nfe/listar.php');
				// $('#btnTransmitir').click();
	          })  
			  
		   
			
		 });
		 
		 //Se clicar em Alterar na Listagem
		 $('.botaoAlterar').live('click', function () {
			//Busco os dados da Nota Selecionada   
			var idLinha = $(this).parent().parent().parent().attr('id');
	        var codigo  = $('#'+ idLinha).find('input:hidden').val(); 			
			  $.getJSON('nfe/carregardados.php?codigo='+codigo, function(registro){						  
				  //$('#tipo_ie option[value="' + registro.tipo_ie + '"]').attr({ selected : "selected" });
				  $("#id_nota").val(codigo);
				  $("#numero").val(registro.id);
				  $("#emissao").val(registro.emissao);
				  $("#saida").val(registro.saida);
				  $("#id_cliente").val(registro.id_cliente);
				  $("#nome_cliente").val(registro.nome_cliente);
				  $("#natureza").val(registro.natureza);
				  $("#inf_ad_contribuinte").val(registro.inf_ad_contribuinte);	
				  $("#inf_ad_fisco").val(registro.inf_ad_fisco);
				  $("#total_produtos").val(registro.valor_produtos);
				  $("#total_desconto").val(registro.desconto);
				  $("#total_frete").val(registro.valor_frete);
				  $("#total_nota").val(registro.valor_total);
				  //Carrego os dados dos campos do tipo Select	
				  $('#finalidade option[value="' + registro.finalidade + '"]').attr({ selected : "selected" });	
				  $('#modFrete option[value="' + registro.frete + '"]').attr({ selected : "selected" });	
				  $('#formapagto option[value="' + registro.formapagto + '"]').attr({ selected : "selected" });			
	      	});  
			
			//Mudo para Aba Cadastro      
			 $("#tabs" ).tabs({beforeActivate: function( event, ui ) {}});
             $("#tabs").tabs( { active: 1 } );
			 $("#incluir").focus();			
		 });
		 
		 //Se clicar na Aba de Produtos sem nenhuma Nota Selecionada Informar que não tem Nota Selecionada    
		 
		 $("#tabs2").tabs({ 
	        beforeActivate: function(event,ui){	
			var numero_nota = $("#id_nota").val();
			if ($("#numero").val() == ""){
				alert("Nenhuma Nota Selecionada");
				return false;
			 }else{		
                $('#listaItens').load('nfe/itensnota.php?id='+numero_nota);
			 }
           // return CheckSomething();
          }
       });
		

		 
		 
		 
	
$("#emissao, #saida").datepicker({
        dateFormat: 'dd/mm/yy', //Formato da Data
		showButtonPanel:true,
		//changeMonth: true, //Permite selecionar outros meses
        //changeYear: true, //Permite Selecionar outros Anos
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
    });

		 
		 
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



<h2><img src="imgs/nfe.png" width="24" height="24" />Emissão de NFe</h2>
  <div id="tabs">
    <ul> 
      <li><a href="#aba-1">Pesquisa</a></li>
      <li><a href="#aba-2">Emissão de NFe</a></li>
    </ul> 
      
    <div id="aba-1"> 
    
       
    <div id="dados">   
     <!-- Aqui Listo os dados Cadastrados -->
    </div>

    </div> 
    <div id="aba-2"> 
    <div id="Botoes">
      <input type="button" id="NovaNota" value="Nova Nota" class="but" />         
      <input type="button" id="alterar" value="Alterar" class="but" />
      <input type="button" id="btnsalvarNFe1" value="salvar" disabled="disabled" class="but" />
      <input type="button" id="btnTransmitir" value="Transmitir" disabled="disabled" class="but" />
      <input type="button" id="btnImprimir" value="Imprimir" class="but" />
      <input type="button" id="btnEnviaEmail" value="Enviar NFe por Email" class="but" />
      <input type="button" id="excluir" value="Cancelar" class="but" />
      <input type="button" id="ConsultaNfe" value="Consultar NFe" class="but" /> 
      <input type="button" id="VerificaStatus" value="Consultar Status do Serviço" class="but" /> 
       </div>
    
    
    <div id="tabs2">
      <ul> 
        <li><a href="#abaGeral">Geral</a></li>
        <li><a href="#abaProdutos">Produtos</a></li>
        <li><a href="#abaValores">Valores</a></li>
      </ul> 
      
      <div id="abaGeral"> 
      
       <div id="Cadastro">
    <div id="Formulario">
    <form method="post" action="" id="grava">
     <table border="0">        
        <tr>
        <td><p class="caption" id="lbl-nome">NÚMERO</p>
                    <input type="hidden" name="id_nota" id="id_nota" size="6" disabled="disabled" />
                     <input type="text" name="numero" id="numero" size="6" disabled="disabled" />
          </td>
        <td>
          <p class="caption" id="lbl-cpf">DATA EMISSÃO</p>
          <input type="text" name="emissao" id="emissao" size="16" disabled="disabled" alt="date" /></td>
        
        <td><p class="caption" id="lbl-nome">DATA SAÍDA</p>
          <input type="text" name="saida" id="saida" size="16" disabled="disabled" alt="date" />
          </td>
        
         <td>
          <p class="caption" id="lbl-nome">Natureza da Operação</p>
          <input type="text" name="natureza" id="natureza" disabled="disabled" /></td> 
          
          </tr>
          
           <tr>
        <td><p class="caption" id="lbl-nome">Finalidade</p>
                    <select name="finalidade" id="finalidade">
                      <option value="1">NFe Normal</option>
                      <option value="2">NFe Complementar</option>
                      <option value="3">NFe de Ajuste</option>
                      <option value="4">NFe Devolução/Retorno</option></select>
          </td>
        <td>
          <p class="caption" id="lbl-cpf">VENDA Á</p>
          <select name="formapagto" id="formapagto">
                      <option value="0">VISTA</option>
                      <option value="1">PRAZO</option>
                      <option value="2">OUTROS</option></select></td>
        
        <td colspan="2"><p class="caption" id="lbl-nome">Modalidade do Frete</p>
           <select name="modFrete" id="modFrete">
                      <option value="9">Sem Frete</option>
                      <option value="0">Por conta do emitente</option>
                      <option value="1">Por conta do destinatário/remetente</option>
                      <option value="2">Por conta de terceiro</option>
                      </select>
          </td>
        
         
          
          </tr>
          
        <tr><td>
          <p class="caption" id="lbl-razao">Código *</p> 
          <input type="text" name="id_cliente" id="id_cliente" size="6" disabled="disabled" /><a href="#dialog2" name="modal">
     <img src="imgs/pesquisa.png" width="29" height="29" /></a><div id="aguarde2" style="float:left;" >
        </td>
        <td colspan="3">
          <p class="caption" id="lbl-nome">Cliente *</p> 
          <input type="text" name="nome_cliente" id="nome_cliente" size="46" disabled="disabled" />
        </td>       
        </tr>
        <tr>
          <td colspan="2">
            <p class="caption" id="lbl-nome">Inf. Adicionais de Interesse do Contribuinte</p> 
              <textarea cols="45" rows="5" name="inf_ad_contribuinte" id="inf_ad_contribuinte" disabled="disabled"></textarea>
          </td>
          <td colspan="2">
          <p class="caption" id="lbl-nome">Inf. Adicionais de Interesse do Fisco</p>
          <textarea cols="45" rows="5" name="inf_ad_fisco" id="inf_ad_fisco" disabled="disabled"> </textarea>
          </td>
       </table>       

    </div></form>       
   </div> 
   </div> 

      
    <div id="abaProdutos"> 
    <div id="InsereItens">
      Produtos<br />
      Código<input type="text" name="codigo_produto" id="codigo_produto" size="13" />
     <a href="#dialog" name="modal">
     <img src="imgs/pesquisa.png" width="29" height="29" /></a><div id="aguarde" ></div>

      Descrição<input type="text" name="nome_produto" id="nome_produto" size="30" />
      Valor UN<input type="text" size="8" id="valor_un" name="valor_un" alt="decimal" />
      Qtd<input type="text" size="6" id="qtd" name="qtd" value="1"/>
      Valor TOTAL<input type="text" size="8" id="valor_total" name="valor_total" alt="decimal" />
      NCM<input type="text" size="8" id="ncm" name="ncm" alt="numero"/>
      <input type="button" value="+ Adicionar" class="btn btn-large btn-success"  name="btnInserirItem" id="btnInserirItem" />
      </div>
           
	<div id="listaItens">
      
    </div>
      
      
    </div>  
    
    <div id="abaValores"> 
      Total dos Produtos<input type="text" size="8" id="total_produtos" name="total_produtos" disabled="disabled" />
      Frete<input type="text" size="8" id="total_frete" name="total_frete" value="0" alt="decimal" />
      Desconto<input type="text" size="8" id="total_desconto" name="total_desconto" value="0" alt="decimal" />
      Valor Total da Nota<input type="text" size="8" id="total_nota" name="total_nota" disabled="disabled" />
    </div>       
         
         
       </div>
    </div> 
 </div>
 
 <div id="boxes">
  <div id="dialog" class="window">
Pesquisar Produtos


<?php
//Incluo o Arquivo com a pesquisa
  include "includes/pesquisa.php";
?>
<a href="#" class="close">Fechar [X]</a>

  </div>
  
   <div id="dialog2" class="window">
Pesquisar Clientes


<?php
//Incluo o Arquivo com a pesquisa
  include "includes/pesquisacliente.php";
?>
<a href="#" class="close">Fechar [X]</a>

  </div>

 </div>
<!-- Máscara para cobrir a tela -->
  <div id="mask"></div> 


