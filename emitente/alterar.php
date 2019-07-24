<?php    
    session_start();
	include_once("../includes/conexao.php");
	@$tabela        = 'emitente';
	@$cnpj          = $_POST['cnpj']; 
	@$ie            = $_POST['ie'];  
	@$im            = $_POST['im']; 
	@$cnae          = $_POST['cnae'];    
	@$nome          = $_POST['nome'];
	@$fantasia      = $_POST['fantasia'];
	@$telefone      = $_POST['telefone'];
	@$cep           = $_POST['cep']; 
	@$endereco      = $_POST['endereco'];
	@$numero        = $_POST['numero'];
	@$bairro        = $_POST['bairro'];
	@$complemento   = $_POST['complemento'];
	@$estado        = $_POST['estado'];
	@$cidade        = $_POST['cidade'];
	@$id_emitente   = $_SESSION["usuario"]["id"];
	
	$buscaEstado = mysqli_query($conexao,"select sigla_estado, nome_cidade from cidades where codigo_cidade = ".$cidade);
	$cidadeEstado = mysqli_fetch_array($buscaEstado);
	$nome_estado = $cidadeEstado["sigla_estado"]; 
	$nome_cidade = $cidadeEstado["nome_cidade"]; 
	 
	
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
		 "cnpj":"'.preg_replace("#[^0-9]#", "",$v_cnpj).'",
		 "ie":"'.  preg_replace("#[^0-9]#", "",$v_ie) .'",
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
		 "pathLogoFile":"/home/emissornfe/public_html/nfephp/images/logo.jpg",
		 "pathLogoNFe":"/home/emissornfe/public_html/nfephp/images/logo-nfe.png",
		 "pathLogoNFCe":"/home/emissornfe/public_html/nfephp/images/logo-nfce.png",
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
	
	
	
	$gravar = mysqli_query($conexao,"update $tabela set 
	 cnpj = '$cnpj', ie = '$ie', im = '$im', cnae = '$cnae', nome = '$nome', fantasia='$fantasia', telefone='$telefone', endereco='$endereco', numero='$numero', cep = '$cep', bairro='$bairro', complemento='$complemento', nome_estado='$nome_estado', nome_cidade = '$nome_cidade', codigo_cidade = '$cidade', codigo_estado = '$estado' where id='$id_emitente'")or die(mysqli_error($conexao)); 
	
	if ($gravar){
	   $caminhoCertificado = "../nfephp/config/config".$id_emitente.".json";
	   if (file_exists($caminhoCertificado)){
		  unlink($caminhoCertificado);  
	   }
	   //Crio a Pasta do Certificado caso não exista
	   $caminhoCertificados = "../nfephp/certs/".$id_emitente."/";
	   //realpath("../../arquivo/nfe/certificado/"); //faça esse path ser verdadeiro
	   if (!file_exists($caminhoCertificados)){
	     mkdir($caminhoCertificados, 0777, true);
	   }
	   $caminhoNfes = "../nfe/arquivos/".$id_emitente."/homologacao/temporarias";
	   //Verifica se existe a pasta onde serão salvas as notas
	   if (!file_exists($caminhoNfes)){
	     mkdir($caminhoNfes, 0777, true);
	   }
	   $caminhoNfesCanceladas = "../nfe/arquivos/".$id_emitente."/homologacao/canceladas";
	   //Verifica se existe a pasta onde serão salvas as notas
	   if (!file_exists($caminhoNfesCanceladas)){
	     mkdir($caminhoNfesCanceladas, 0777, true);
	   }
	   $caminhoNfesGeradas = "../nfe/arquivos/".$id_emitente."/entradas";
	    //Verifica se existe a pasta onde serão salvas as notas
	   if (!file_exists($caminhoNfesGeradas)){
	     mkdir($caminhoNfesGeradas, 0777, true);
	   }
	   
	   $caminhoNfes = "arquivos/".$id_emitente; 

	   $caminhoCertificado ="/home/emissornfe/public_html/nfephp/certs/".$id_emitente."/";
       CriarArquivoEmitente($id_emitente, $nome, $fantasia, $nome_estado, $cnpj, $ie, $caminhoCertificado, $caminhoNfes);
		echo "0";
	} else {
		echo '<label><img src="imgs/erro.png" width="16" height="16" /> Problema ao Salvar dados</label>';	
	}
?>