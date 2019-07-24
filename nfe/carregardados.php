<?php 
    session_start();   
	include_once("../includes/conexao.php");
	$codigo    = $_GET["codigo"];
	$id_emitente   = $_SESSION["usuario"]["id"];
	$tabela    = "nota1";
	$dados     = mysqli_query($conexao,"select id, id_emitente, natureza, id_cliente, nome_cliente, id_transportadora, nome_transportadora, inf_ad_contribuinte, inf_ad_fisco, date_format(emissao,'%d/%m/%Y') as emissao, date_format(saida,'%d/%m/%Y') as saida, valor_produtos, desconto, valor_frete, valor_total, frete, finalidade, formapagto from $tabela where id_nota = '$codigo' and id_emitente = '$id_emitente'");
	$resultado = mysqli_fetch_array($dados);
    extract($resultado);
    echo json_encode($resultado);
?>