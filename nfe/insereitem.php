<?php  
    session_start();  
	include_once("../includes/conexao.php");
	@$tabela        = 'nota2';
	
	function moeda($get_valor) {
		$source = array('.', ','); 
		$replace = array('', '.');
		$valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
		return $valor; //retorna o valor formatado para gravar no banco

	}
	
	@$id_emitente   = $_SESSION["usuario"]["id"];
	@$id_produto    = $_POST["codigo_produto"];
	@$nome          = $_POST["nome"];
	@$qtd           = $_POST["qtd"];
	@$valorun       = moeda($_POST["valor_un"]);
	@$valortotal    = moeda($_POST["valor_total"]);
	@$id_nota       = $_POST["numero_nota"];
	@$cfop          = "5102";//$_POST["cfop"];
	@$ncm           = $_POST["ncm"];
	@$cest          = "";//$_POST["cfop"];
	
	
	
	
    $gravar = mysqli_query($conexao,"INSERT INTO $tabela 
	 ( id_emitente, id_produto, nome, valor_un, qtd, valor_total, cfop, ncm, cest, id_nota) VALUES
	 ('$id_emitente','$id_produto','$nome','$valorun','$qtd','$valortotal','$cfop', '$ncm', '$cest', '$id_nota')")or die(mysqli_error($conexao)); 
	 
	 //Atualiza o Valor Total da Nota
	 $atualizatotal = mysqli_query($conexao,"update nota1 set 
	 valor_produtos = (select sum(valor_total) from nota2 where id_nota = '$id_nota' and id_emitente = '$id_emitente')
	 where id_nota = '$id_nota' and id_emitente = '$id_emitente'");
	 
	if ($gravar){
		echo 0;		
	} else {
		echo 1;	
	}
	 
	

?>