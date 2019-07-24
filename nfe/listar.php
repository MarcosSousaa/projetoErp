<?php
  session_start(); 
?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<link rel="stylesheet" href="includes/datatable/estilo/table_jui.css" />
<link rel="stylesheet" href="includes/datatable/estilo/jquery-ui-1.8.4.custom.css" />
<style>
tr{
	  cursor:pointer; 	
	}
	.ex_highlight #grid1 tbody tr.even:hover, #grid1 tbody tr.even td.highlighted {
	background-color: #ECFFB3;
}

.ex_highlight #grid1 tbody tr.odd:hover, #grid1 tbody tr.odd td.highlighted {
	background-color: #E6FF99;
}

.ex_highlight_row #grid1 tr.even:hover {
	background-color: #ECFFB3;
}
</style>
 <script src="includes/jquery.js"></script>
 <script src="includes/jquery-ui.js"></script>
 <script type="text/javascript" src="includes/datatable/js/jquery.dataTables.min.js"></script>
 <script type="text/javascript">
 $(document).ready(function() {	

	oTable = $('#grid1').dataTable({		
		"bPaginate": true,
		"bJQueryUI": true,
		"sPaginationType": "full_numbers", 
		"sSearch": "Pesquisar: ",
           "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Pesquisar: ",
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        }

	});




	  
	});
		</script>

 <table border="1px" cellpadding="5px" cellspacing="0" class="display" id="grid1" width="100%" style="font-size:10px">
  <thead>
    <tr> 
       <th style="width:20px">Número</th>  
       <th style="width:170px">Data de Emissão</th>
       <th style="width:100px">Cliente</th>
       <th style="width:60px">Total</th>
       <th style="width:30px">A&ccedil;&otilde;es</th>
     </tr>
    </thead>
    <tbody> 
<?php       
	include_once("../includes/conexao.php");
	$tabela = 'nota1';
	$id_emitente   = $_SESSION["usuario"]["id"];
	$Estilotransmitida = "class='gradeA'";
	$EstiloCancelada   = "class='gradeX odd'";
	
	$listar = mysqli_query($conexao, "select * from $tabela where id_emitente = '$id_emitente' order by id");
	$l = 1;
	while ($dados = mysqli_fetch_array($listar)){
		if ($dados["cancelada"] == 'S'){
		   echo '<tr id="linha'.$l.'" '.$EstiloCancelada.'>'; 	
		}else if ($dados["codigo_status_nfe"] == 100){
			echo '<tr id="linha'.$l.'" '.$Estilotransmitida.'>';					  	
		}else{
		  echo '<tr id="linha'.$l.'">';		
		}
	  echo '	  
        <td><input type="hidden" name="IdCliente" id="IdCliente" value="'.$dados["id_nota"].'" />'.$dados["id"].'</td>
        <td>'.date("d/m/Y", strtotime($dados["emissao"])).'</td>
        <td>'.$dados["nome_cliente"].'</td>
        <td>'.$dados["valor_produtos"].'</td>
        <td><a href="#"><img src="imgs/editar.png" border="0" class="botaoAlterar"></ 
		    <a href="#"><img src="imgs/apagar.gif" border="0" class="botaoExcluir"></</td>
      </tr>
	  ';
	  $l++;	
	}
?>
   </tbody>
</table>
