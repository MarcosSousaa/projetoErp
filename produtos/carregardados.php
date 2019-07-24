<?php 
    session_start();   
	include_once("../includes/conexao.php");
	$codigo    = $_GET["codigo"];
	$id_emitente   = $_SESSION["usuario"]["id"];
	$tabela    = "produtos";
	$dados     = mysqli_query($conexao,"select * from $tabela where id = '$codigo' and id_emitente = '$id_emitente'");
	$resultado = mysqli_fetch_array($dados);
    extract($resultado);
    echo json_encode($resultado);
?>