<?php
@session_start();
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
		"sPaginationType": "full_numbers"
	});
	 
	  
	});
		</script>

 <table border="1px" cellpadding="5px" cellspacing="0" class="display" id="grid1" width="100%" style="font-size:10px">
  <thead>
    <tr> 
       <th style="width:20px">ID</th>  
       <th style="width:170px">Nome</th>
       <th style="width:100px">CNPJ</th>
       <th style="width:60px">Telefone</th>
       <th style="width:30px">A&ccedil;&otilde;es</th>
     </tr>
    </thead>
    <tbody> 
<?php      
	include_once("../includes/conexao.php");
	$tabela = 'clientes';
	
	$idemitente = $_SESSION["emitente"]["id"];
	
	$listar = mysqli_query($conexao, "select * from $tabela where id_emitente = '$idemitente'");
	$l = 1;
	while ($dados = mysqli_fetch_array($listar)){		
	  echo '
	  <tr id="linha'.$l.'">
        <td><input type="hidden" name="IdCliente" id="IdCliente" value="'.$dados["id"].'" />'.$dados["id"].'</td>
        <td>'.$dados["nome"].'</td>
        <td>'.$dados["cpf_cnpj"].'</td>
        <td>'.$dados["telefone"].'</td>
        <td><a href="#"><img src="imgs/editar.png" border="0" class="botaoAlterar"></ 
		    <a href="#"><img src="imgs/apagar.gif" border="0" class="botaoExcluir"></</td>
      </tr>
	  ';
	  $l++;	
	}
?>
   </tbody>
</table>
