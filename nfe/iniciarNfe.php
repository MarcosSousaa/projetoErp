<?php  
    session_start();  
	include_once("../includes/conexao.php");
	@$tabela        = 'nota1';
	@$id_emitente   = $_SESSION["usuario"]["id"];
	
	//Gerar ID Da Nota
	$geraCod = mysqli_query($conexao,"select coalesce(max(id),0) + 1 as id from $tabela where id_emitente = '$id_emitente'");
    
	if (mysqli_num_rows($geraCod)>0){
	  $cod = mysqli_fetch_array($geraCod);
	  $novoCod = $cod["id"];
	}else{
	  $novoCod = 1;	
	}
	
	
	
    $gravar = mysqli_query($conexao,"INSERT INTO $tabela 
	 (id_nota, id, id_emitente, natureza, emissao, saida) VALUES
	 (0, '$novoCod','$id_emitente','VENDA DE MERCADORIA',now(),now())")or die(mysqli_error($conexao)); 
	 
	 $ultimoId = mysqli_insert_id($conexao);
	 $dadosGerados = mysqli_query($conexao, "select id_nota, id from $tabela where id_nota = '$ultimoId' ");

	 
	if (!$gravar){
		echo 0;		
	} else {
		//echo $novoCod;
		$resultado = mysqli_fetch_array($dadosGerados);
        extract($resultado);
        echo json_encode($resultado);
	}
	 
	

?>