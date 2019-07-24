<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../nfephp/bootstrap.php';
@$id_emitente   = $_SESSION["usuario"]["id"];

$caminhoCertificados = "../nfephp/certs/".$id_emitente."/certificado.pfx";
if (!file_exists($caminhoCertificados)){  //Verifico se Existe CErtificado Cadastrado
	     echo "Certificado Digital não encontrado, favor inserir um Certificado Válido!";
		 exit;
	   }

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe('../nfephp/config/config'.$id_emitente.'.json');
//$nfe->ativaContingencia('GO','Contingência Ativada pela SEFAZ GO desde 08/10/2010 18:00:00','');
//$nfe->desativaContingencia();
$nfe->setModelo('55');

$aResposta = array();
$siglaUF = $_SESSION["emitente"]["nome_estado"];//'SP';
$tpAmb = $_SESSION["ambiente"];
$retorno = $nfe->sefazStatus($siglaUF, $tpAmb, $aResposta);
//echo '<br><br><pre>';
//echo htmlspecialchars($nfe->soapDebug);
//echo '</pre><br><br><pre>';
//print_r($aResposta); //Mostra o Array com o retorno Completo
echo $aResposta["xMotivo"];


