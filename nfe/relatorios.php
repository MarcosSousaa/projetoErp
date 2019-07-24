<link rel="stylesheet" href="includes/datatable/estilo/table_jui.css" />
<link rel="stylesheet" href="includes/datatable/estilo/jquery-ui-1.8.4.custom.css" />
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

$("#de, #ate").datepicker({
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
	
	  
	
	$("#btnGeraRelatorio").click(function(ev){
        ev.preventDefault();
		$("#btnGeraRelatorio").val("Gerando...");
		try{
	 	  $("#btnGeraRelatorio").prop("disabled", true);
          if ($.trim($("#de").val()) == ""){
		    alert("Favor Informe a data De");
		    $("#de").focus();
		    return false;	
		  }
		  if ($.trim($("#de").val()) == ""){
		    alert("Favor Informe a data Até");
		    $("#de").focus();
		    return false;	
		  }
		  $("#formRelatorio").submit();
		    
		  return true;
		}finally{
		  $("#btnGeraRelatorio").val("Emitir Relatório");
		  $("#btnGeraRelatorio").prop("disabled", false);	
		}			
		
    });


	  
	}); 
	
	
</script>

<h1>Relatório de NFes</h1>
<form method="post" name="formRelatorio" id="formRelatorio" action="nfe/RelatorioDeNotas.php" target="_blank">
 <table border="0">    
        <tr>
          <td colspan="2" align="left" valign="bottom"><b>Selecione o Período</b></td>
        </tr>    
        <tr>
        <td width="101">
          <p class="caption" id="lbl-cpf">De</p>
          <input type="text" name="de" id="de" size="16" alt="date" /></td>
        
        <td width="295"><p class="caption" id="lbl-nome">Até</p>
          <input type="text" name="ate" id="ate" size="16" alt="date" />
          </td>
        
       </tr>
       <tr>
          <td colspan="2" align="left" valign="bottom"><b>Selecione o Cliente, ou deixe Vazio para pesquisar todos</b></td>
        </tr>
          
        <tr><td>
          <p class="caption" id="lbl-razao">Código *</p> 
          <input type="text" name="id_cliente" id="id_cliente" size="6" /><a href="#dialog2" name="modal">
     <img src="imgs/pesquisa.png" width="29" height="29" /></a><div id="aguarde2" style="float:left;" >
        </td>
        <td colspan="3">
          <p class="caption" id="lbl-nome">Cliente *</p> 
          <input type="text" name="nome_cliente" id="nome_cliente" size="46" value="TODOS" disabled />
        </td>       
        </tr>
        <tr>
          <td colspan="4"><input type="radio" name="nfe" id="nfe" value="0" checked> - Todas as NFes(Transmitidas e Canceladas) <br />
                          <input type="radio" name="nfe" id="nfe" value="1"  NFes Transmitidas > - Somente as Nfes Transmitidas <br />
                          <input type="radio" name="nfe" id="nfe" value="2"> - Somente as NFes Canceladas</td>
        </tr>
        <tr>
          <td colspan="4" align="right"><input type="submit" name="btnGeraRelatorio" id="btnGeraRelatorio" value="Emitir Relatório" style="padding:5px;"></td>
        </tr>
 </table>  
 </form>     
