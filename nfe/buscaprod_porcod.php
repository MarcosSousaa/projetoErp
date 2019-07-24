<?php
 session_start();  
	include_once("../includes/conexao.php");
	@$tabela        = 'produtos';
	@$id_emitente   = $_SESSION["usuario"]["id"];
	@$cod   = $_GET["codigo_produto"];
	
	//Gerar Código
	$encontrou = mysqli_query($conexao,"select nome, valor, un, ncm from $tabela where id_emitente = '$id_emitente' and id = '$cod'");
    
	if (mysqli_num_rows($encontrou)>0){
	  $produto = mysqli_fetch_array($encontrou);
	 echo json_encode($produto);
	}else{
	  echo "0";	
	}
?>
