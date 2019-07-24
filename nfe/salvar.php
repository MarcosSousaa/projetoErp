<?php  
    session_start();  
	include_once("../includes/conexao.php");
	include_once("../includes/funcoes.php");
	//include_once("gerarnfe.php");
    //echo "Mensagem";
	
	function moeda($get_valor) {
		$source = array('.', ','); 
		$replace = array('', '.');
		$valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
		return $valor; //retorna o valor formatado para gravar no banco

	}
	
	@$tabela              = 'nota1';
	@$numero              = $_POST['numero_nota'];
	@$id_nota             = $_POST['id_nota'];
	@$emissao             = formatarData($_POST['emissao']); 
	@$saida               = formatarData($_POST['saida']); 
	@$natureza            = $_POST['natureza'];     
	@$id_cliente          = $_POST['id_cliente'];
	@$nome_cliente        = $_POST['nome_cliente'];
	@$inf_ad_contribuinte = $_POST['inf_ad_contribuinte'];
	@$inf_ad_fisco        = $_POST['inf_ad_fisco']; 
	@$finalidade          = $_POST['finalidade']; 
	@$modFrete            = $_POST['modFrete']; 
	@$formapagto          = $_POST['formapagto']; 
	@$acao                = $_POST['acao']; 
	@$id_emitente         = $_SESSION["usuario"]["id"];
	@$desconto            = moeda($_POST['desconto']);
	@$frete               = moeda($_POST['frete']);
	@$totalprodutos       = moeda($_POST['totalprodutos']);
	@$totalnfe            = moeda($_POST['totalnfe']);
	
	   
	//echo "ID do Cliente =". $id_cliente;
	
	//Grava os dados atualizados da Nota
	$gravar = mysqli_query($conexao,"update $tabela set emissao='$emissao', saida='$saida', natureza='$natureza', id_cliente='$id_cliente', nome_cliente=upper('$nome_cliente'), inf_ad_contribuinte=upper('$inf_ad_contribuinte'), inf_ad_fisco=upper('$inf_ad_fisco'), finalidade='$finalidade', frete='$modFrete', formapagto = '$formapagto', valor_frete = '$frete', valor_produtos = '$totalprodutos', desconto = '$desconto', valor_total = '$totalnfe',  id = '$numero'  WHERE id_emitente = '$id_emitente' and id_nota = '$id_nota'")or die(mysqli_error($conexao)); 
	
	if ($gravar){
		echo "0";		
	} else {
		echo "1";	
	}

?>