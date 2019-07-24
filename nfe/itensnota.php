<?php
session_start();
?>
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
        function CalculaValores(){
	   var
		numero_nota         = $('#id_nota', parent.document).val();
		totalFrete          = getMoney($('#total_frete', parent.document).val());	
		totalDesconto       = getMoney($('#total_desconto', parent.document).val());
		totalNota           = 0;
		$.getJSON('nfe/atualizavalores.php?id='+numero_nota, function(resposta){
			//Soma Total dos Produtos	
			totalProdutos = getMoney(resposta[0]);
			totalNota     = formatReal(totalProdutos + totalFrete - totalDesconto);
			
			//Calcula o Frete se Houver
			if ( ($('#total_frete', parent.document).val() != '') || ($('#total_frete', parent.document).val() != '0') ){
		     $('#total_nota').val(formatReal(totalProdutos+totalFrete-totalDesconto));
		    }
			
			//Calcula o Desconto se Houver
			 if (totalDesconto > totalProdutos){
			    $('#total_desconto', parent.document).val('0,00')
			    alert("Valor do desconto não pode ser maior que a soma dos produtos da nota");
			    $('#total_desconto', parent.document).focus();
			    return false;
		     }
		   if ( ($('#total_desconto', parent.document).val() != '') || ($('#total_desconto', parent.document).val() != '0') ){
		     $('#total_nota', parent.document).val(formatReal(totalProdutos+totalFrete-totalDesconto));
		   }
		    
			$('#total_produtos', parent.document).val(formatReal(totalProdutos));
			$('#total_nota', parent.document).val(totalNota); 			
		  });
		 }

	
	 $('.BotaoExcluiritem').click(function(){
		 var idLinha = $(this).parent().parent().attr('id');
	      var codigo      = $('#'+ idLinha).find('input:hidden').val(); 
		 var numero_nota = $('#id_nota', parent.document).val();
		// alert("Numero:"+numero_nota+ "IDItem:"+ codigo);
		 $.post('nfe/excluiritem.php',{codigo:codigo, numero_nota:numero_nota}, function(resposta){
			// alert(resposta);
				if (resposta==0){					  		
                  $('#listaItens').load('nfe/itensnota.php?id='+numero_nota);	
				  CalculaValores()
				}else{
				  alert("Não foi possivel excluir o item!");	
				}
	          }) 			
		
		 });
	 
	  
	});
		</script>
 <table border="1px" cellpadding="5px" cellspacing="0" class="TabelaItens" id="grid2" width="100%" style="font-size:10px">
  <thead>
    <tr> 
       <th style="width:20px">Código</th>  
       <th style="width:170px">Descrição</th>
       <th style="width:100px">Valor UN.</th>
       <th style="width:60px">QTD</th>
       <th style="width:30px">VALOR TOTAL</th>
       <th style="width:30px">NCM</th>
       <th style="width:30px">A&ccedil;&otilde;es</th>
     </tr>
    </thead>
    <tbody> 
<?php       
	include_once("../includes/conexao.php");
	
	$id = $_GET["id"];
	
	$listar = mysqli_query($conexao, "select * from nota2 where id_nota = '$id'");
	$l = 1;
	while ($dados = mysqli_fetch_array($listar)){		
	  echo '
	  <tr id="item'.$l.'"><input type="hidden" name="IdItem" id="IdItem" value="'.$dados["id"].'" /><input type="hidden" name="idNota" id="idNota" value="'.$dados["id_nota"].'" />
        <td>'.$dados["id"].'</td>
        <td>'.$dados["nome"].'</td>
        <td>'.$dados["valor_un"].'</td>
        <td>'.$dados["qtd"].'</td>
        <td>'.$dados["valor_total"].'</td>
		<td>'.$dados["ncm"].'</td>
		<td><img src="imgs/editar.png" border="0" class="botaoAlterar"> 
		    <img src="imgs/apagar.gif" border="0" class="BotaoExcluiritem" style="cursor:pointer"></td>
      </tr>
	  ';
	  $l++;	
	}
?>
   </tbody>
</table>
