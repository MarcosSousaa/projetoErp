<?php    
	include_once("../includes/conexao.php");
	@$tabela      = 'emitente';
	@$cnpj        = $_POST['cnpj']; 
	@$ie          = $_POST['ie'];     
	@$nome        = $_POST['nome'];
	@$fantasia    = $_POST['fantasia'];
	@$telefone    = $_POST['telefone'];
	@$cep         = $_POST['cep']; 
	@$endereco    = $_POST['endereco'];
	@$numero      = $_POST['numero'];
	@$bairro      = $_POST['bairro'];
	@$complemento = $_POST['complemento'];
	@$estado      = $_POST['estado'];
	@$cidade      = $_POST['cidade'];
	@$email       = $_POST['email'];
	@$senha       = $_POST['senha'];
	@$plano       = $_POST['plano'];
	
	
	//Válida email e CNPJ
	$validaremail = mysqli_query($conexao,"select cnpj from emitente where email = '$email'");
	if (mysqli_num_rows($validaremail)){
	  echo '<label><img src="imgs/erro.png" width="16" height="16" /> Este EMAIL: '.$email.', já foi Cadastrado, caso você tenha informado corretamente entre em contato conosco</label>';	
	  exit;
	}
	
	//Válida email e CNPJ
	$validarcnpj = mysqli_query($conexao,"select cnpj from emitente where cnpj = '$cnpj'");
	if (mysqli_num_rows($validarcnpj)){
	  echo '<label><img src="imgs/erro.png" width="16" height="16" /> Este CNPJ '.$cnpj.', já foi Cadastrado, caso você tenha informado corretamente entre em contato conosco</label>';	
	  exit;
	}
	
	
	
	$buscaEstado = mysqli_query($conexao,"select sigla_estado, nome_cidade from cidades where codigo_cidade = ".$cidade);
	$cidadeEstado = mysqli_fetch_array($buscaEstado);
	$nome_estado = $cidadeEstado["sigla_estado"]; 
	$nome_cidade = $cidadeEstado["nome_cidade"]; 
	
	//$nome_estado = 'SP';
	
	function CriarArquivoEmitente($v_id, $v_razao, $v_fantasia, $v_estado, $v_cnpj, $v_ie, $v_caminhoCertificado, $v_caminhoNfe){
		try{
		 $fp = fopen("../nfephp/config/config".$v_id.".json", "a");
          // Escreve "exemplo de escrita" no bloco1.txt
         $escreve = fwrite($fp, 
		 '
		 {
		 "atualizacao":"'.date("Y/m/d H:i:s").'",
		 "tpAmb":2,
		 "pathXmlUrlFileNFe":"nfe_ws3_mod55.xml",
		 "pathXmlUrlFileCTe":"cte_ws2.xml",
		 "pathXmlUrlFileMDFe":"mdf2_ws1.xml",
		 "pathXmlUrlFileCLe":"",
		 "pathXmlUrlFileNFSe":"",
		 "pathNFeFiles":"'.$v_caminhoNfe.'",
		 "pathCTeFiles":"",
		 "pathMDFeFiles":"",
		 "pathCLeFiles":"",
		 "pathNFSeFiles":"",
		 "pathCertsFiles":"'.$v_caminhoCertificado.'",
		 "siteUrl":"http://'.$_SERVER['SERVER_NAME'].'",
		 "schemesNFe":"PL_008i2",
		 "schemesCTe":"PL_CTe_200",
		 "schemesMDFe":"PL_MDFe_100",
		 "schemesCLe":"",
		 "schemesNFSe":"",
		 "razaosocial":"'.$v_razao.'",
		 "nomefantasia":"'.$v_fantasia.'",
		 "siglaUF":"'.$nome_estado.'",
		 "cnpj":"'. preg_replace("#[^0-9]#", "",$v_cnpj) .'",
		 "ie":"'. preg_replace("#[^0-9]#", "",$v_ie) .'",
		 "im":"",
		 "iest":"",
		 "cnae":"",
		 "regime":1,
		 "tokenIBPT":"",
		 "tokenNFCe":"",
		 "tokenNFCeId":"",
		 "certPfxName":"certificado.pfx",
		 "certPassword":"123456","certPhrase":"",
		 "aDocFormat":{"format":"L","paper":"A4","southpaw":"1",
		 "pathLogoFile":"E:\\\Sistemas\\\wamp\\\www\\\sac\\\nfephp-master\\\images\\\logo.jpg",
		 "pathLogoNFe":"E:\\\Sistemas\\\wamp\\\www\\\sac\\\nfephp-master\\\images\\\logo-nfe.png",
		 "pathLogoNFCe":"E:\\\Sistemas\\\wamp\\\www\\\sac\\\nfephp-master\\\images\\\logo-nfce.png",
		 "logoPosition":"L",
		 "font":"Times","printer":""},
		 "aMailConf":{"mailAuth":"1",
		 "mailFrom":false,
		 "mailSmtp":"",
		 "mailUser":"",
		 "mailPass":"",
		 "mailProtocol":"",
		 "mailPort":"",
		 "mailFromMail":false,
		 "mailFromName":"",
		 "mailReplayToMail":false,
		 "mailReplayToName":"",
		 "mailImapHost":null,"mailImapPort":null,
		 "mailImapSecurity":null,
		 "mailImapNocerts":null,
		 "mailImapBox":null},
		 "aProxyConf":{"proxyIp":"",
		 "proxyPort":"",
		 "proxyUser":"",
		 "proxyPass":""}
		 }'
		 );

        // Fecha o arquivo
         fclose($fp);// -> OK	
	     return true;
	  }catch (Exception $e) {
		return false;
	  }
	}
	
	$data_vencimento = date('Y-m-d', strtotime(date('Y-m-d H:i'). ' + 30 days'));
	
	$gravar = mysqli_query($conexao,"INSERT INTO $tabela 
	 (cnpj,     ie,    nome,   fantasia,     telefone,    endereco,   numero,    bairro,    complemento, codigo_estado, nome_estado, nome_cidade, senha, email, data_cadastro, data_vencimento, plano)      VALUES
	 ('$cnpj', '$ie', '$nome', '$fantasia', '$telefone', '$endereco', '$numero', '$bairro', '$complemento', '$estado', '$nome_estado', '$cidade', '$senha', '$email', now(), '$data_vencimento', '$plano')")or die(mysqli_error($conexao)); 
	
	if ($gravar){
		$idGerado = mysqli_insert_id($conexao);
		$caminhoCertificado = "../nfephp/config/config".$idGerado.".json";
	   if (file_exists($caminhoCertificado)){
		  unlink($caminhoCertificado);  
	   }
	   //Crio a Pasta do Certificado caso não exista
	   $caminhoCertificados = "../nfephp/certs/".$idGerado."/";
	   //realpath("../../arquivo/nfe/certificado/"); //faça esse path ser verdadeiro
	   if (!file_exists($caminhoCertificados)){
	     mkdir($caminhoCertificados, 0777, true);
	   }
	   $caminhoNfes = "../nfe/arquivos/".$idGerado."/homologacao/temporarias";
	   //Verifica se existe a pasta onde serão salvas as notas
	   if (!file_exists($caminhoNfes)){
	     mkdir($caminhoNfes, 0777, true);
	   }
	   $caminhoNfesCanceladas = "../nfe/arquivos/".$idGerado."/homologacao/canceladas";
	   //Verifica se existe a pasta onde serão salvas as notas
	   if (!file_exists($caminhoNfesCanceladas)){
	     mkdir($caminhoNfesCanceladas, 0777, true);
	   }
	   $caminhoNfesGeradas = "../nfe/arquivos/".$idGerado."/entradas";
	    //Verifica se existe a pasta onde serão salvas as notas
	   if (!file_exists($caminhoNfesGeradas)){
	     mkdir($caminhoNfesGeradas, 0777, true);
	   }
	   $caminhoNfes = "arquivos/".$idGerado; 
       $caminhoCertificado ="/home/emissornfe/public_html/nfephp/certs/".$idGerado."/";
	   CriarArquivoEmitente($idGerado, $nome, $fantasia, $nome_estado, $cnpj, $ie, $caminhoCertificado, $caminhoNfes);
		echo '<label><img src="imgs/accept.png" width="16" height="16" /> Empresa Gravada com sucesso, Faça seu login e emita suas NFes agora!</label>';
	} else {
		echo '<label><img src="imgs/erro.png" width="16" height="16" /> Problema na gravação</label>';	
	}
?>