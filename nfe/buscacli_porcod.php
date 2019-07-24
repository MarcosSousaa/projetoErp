<?php
 session_start();  
	include_once("../includes/conexao.php");
	@$tabela        = 'clientes';
	@$id_emitente   = $_SESSION["usuario"]["id"];
	@$cod   = $_GET["codigo_cliente"];
	
	//Gerar Código
	$encontrou = mysqli_query($conexao,"select id, nome from $tabela where id_emitente = '$id_emitente' and id = '$cod'");
    
	if (mysqli_num_rows($encontrou)>0){
	  $cliente = mysqli_fetch_array($encontrou);
	 echo json_encode($cliente);
	}else{
	  echo "0";	
	}
?>
