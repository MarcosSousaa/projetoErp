<?php  
    session_start();  
	include_once("../includes/conexao.php");
	@$tabela        = 'nota2';
	@$numero        = $_POST["numero_nota"];
	@$id_emitente   = $_SESSION["usuario"]["id"];
	@$iditem        = $_POST["codigo"];
	
	
    $gravar = mysqli_query($conexao,"delete from $tabela where id = '$iditem'")or die(mysqli_error($conexao));
	
	//Atualiza o Valor Total da Nota
	 $atualizatotal = mysqli_query($conexao,"update nota1 set valor_produtos = 
	 (select sum(valor_total) from nota2 where id_nota = '$numero' and id_emitente = '$id_emitente') where id_nota = '$numero' and id_emitente = '$id_emitente'")or die(mysqli_error($conexao));
	 
	if ($gravar){
		echo 0;		
	} else {
		echo 1;	
	}
	 
	

?>