<?php  
    session_start();  
	include_once("../includes/conexao.php");
	@$tabela        = 'clientes';
	@$pessoa        = $_POST['pessoa'];
	@$cnpj          = $_POST['cnpj']; 
	@$tipo_ie       = $_POST['tipo_ie']; 
	@$ie            = $_POST['ie'];     
	@$nome          = $_POST['nome'];
	@$fantasia      = $_POST['fantasia'];
	@$telefone      = $_POST['telefone'];
	@$cep           = $_POST['cep']; 
	@$endereco      = $_POST['endereco'];
	@$numero        = $_POST['numero'];
	@$bairro        = $_POST['bairro'];
	@$complemento   = $_POST['complemento'];
	@$codigo_estado = $_POST['codigo_estado'];
	@$estado        = $_POST['estado'];
	@$codigo_cidade = $_POST['codigo_cidade'];
	@$cidade        = $_POST['cidade'];
	@$email         = $_POST['email'];
	@$senha         = $_POST['senha'];
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
	 (id, id_emitente, pessoa, cpf_cnpj, tipo_ie, ie, nome, fantasia, telefone, cep, endereco, numero, bairro, complemento,codigo_estado,  nome_estado, codigo_cidade, nome_cidade,  email)      VALUES
	 ('$novoCod','$id_emitente','$pessoa','$cnpj', '$tipo_ie', '$ie', upper('$nome'), upper('$fantasia'), '$telefone', '$cep', upper('$endereco'), '$numero', upper('$bairro'), upper('$complemento'), '$codigo_estado','$estado', '$codigo_cidade','$cidade', upper('$email'))")or die(mysqli_error($conexao)); 
	 
	if ($gravar){
		echo "Registro Gravado com Sucesso";		
	} else {
		echo "Erro ao efetuar cadastro!";	
	}
	 
	}else{
	//Atualiza os dados	
	$gravar = mysqli_query($conexao,"update $tabela set pessoa = '$pessoa', cpf_cnpj = '$cnpj', tipo_ie = '$tipo_ie', ie='$ie', nome=upper('$nome'), fantasia=upper('$fantasia'), telefone='$telefone', cep = '$cep', endereco=upper('$endereco'), numero='$numero', bairro=upper('$bairro'), complemento=upper('$complemento'),codigo_estado='$codigo_estado',  nome_estado='$estado', codigo_cidade='$codigo_cidade', nome_cidade='$cidade',  email=upper('$email') WHERE id_emitente = '$id_emitente' and id = '$id'")or die(mysqli_error($conexao)); 
	
	if ($gravar){
		echo "Registro Alterado com Sucesso!";		
	} else {
		echo "Erro ao efetuar alteração!";	
	}
	}
	
	
?>