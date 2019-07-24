<?php
    include("../includes/conexao.php");
	include("../includes/funcoes.php");
	$id = mysqli_real_escape_string($conexao,$_POST['codigo']);
	if (mysqli_query($conexao,"DELETE FROM clientes WHERE id='$id'"))
	{
		echo '<p><img src="imgs/delete.png" width="16" height="16" /> Cliente Excluído</p>';
	} else {
		echo 'Problema na exclusão';	
	}
?>