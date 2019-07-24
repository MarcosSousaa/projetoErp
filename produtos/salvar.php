<?php  
    session_start();  
	include_once("../includes/conexao.php");
	@$tabela        = 'produtos';
	@$codigo        = $_POST['id'];
	@$nome          = $_POST['nome']; 
	@$un            = $_POST['un']; 
	@$ncm           = $_POST['ncm'];     
	@$cest          = $_POST['cest'];
	@$valor         = $_POST['valor'];
    @$estoque       = $_POST['estoque'];
	@$id_emitente   = $_SESSION["usuario"]["id"];
	@$acao          = $_POST['acao'];
	@$id            = $_POST['id'];
	
    if ($acao == 'I'){
		//Insere os dados
	//Gerar Código
	$geraCod = mysqli_query($conexao,"select (max(COALESCE(id,0)) + 1) as id from $tabela where id_emitente = '$id_emitente'");
    
	if (mysqli_num_rows($geraCod)>0){
	  $cod = mysqli_fetch_array($geraCod);
	  $novoCod = $cod["id"];
	}else{
	  $novoCod = 1;	
	}
		echo "Codigo Gerado: $novoCod";
		
	$gravar = mysqli_query($conexao,"INSERT INTO $tabela 
	 (id, id_emitente, nome, un, ncm, cest, estoque, valor)      VALUES
	 ('$novoCod','$id_emitente','$nome','$un', '$ncm', '$cest', '$estoque', '$valor')")or die(mysqli_error($conexao)); 
	 
	if ($gravar){
		echo "Registro Gravado com Sucesso";		
	} else {
		echo "Erro ao efetuar cadastro!";	
	}
	 
	}else{
	//Atualiza os dados	
	$gravar = mysqli_query($conexao,"update $tabela set nome = '$nome', un = '$un', ncm = '$ncm', cest='$cest', estoque = '$estoque', valor='$valor' WHERE id_emitente = '$id_emitente' and id = '$id'")or die(mysqli_error($conexao)); 
	
	if ($gravar){
		echo "Registro Alterado com Sucesso";		
	} else {
		echo "Erro ao efetuar alteração!";	
	}
	}
	
	
?>