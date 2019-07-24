<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../nfephp/bootstrap.php';
$id_emitente   = $_SESSION["usuario"]["id"];

$caminhoCertificados = "../nfephp/certs/".$id_emitente."/certificado.pfx";
if (!file_exists($caminhoCertificados)){  //Verifico se Existe CErtificado Cadastrado
	     echo "Certificado Digital não encontrado, favor inserir um Certificado Válido!";
		 exit;
	   }

use NFePHP\NFe\ToolsNFe;

//$nfe = new ToolsNFe('../nfephp/config/config.json');
$nfe = new ToolsNFe('../nfephp/config/config'.$id_emitente.'.json');
$nfe->setModelo('55');

$aResposta = array();
//$chave = '35161047265798000167550010000000141000000149';

include_once("../includes/conexao.php");
$numero = $_POST["numero_nota"];
$pegaChavenoBD2 = mysqli_query($conexao,"select chave_nfe from nota1 where id = '$numero'");
$pegaChavenoBD = mysqli_fetch_array($pegaChavenoBD2);
$chave = $pegaChavenoBD["chave_nfe"];
$tpAmb = '2'; //1=Produção; 2=Homologação
// $aXml = file_get_contents("/var/www/nfe/homologacao/assinadas/{$chave}-nfe.xml"); // Ambiente Linux
$aXml = file_get_contents("arquivos/$id_emitente/entradas/{$chave}-nfe.xml"); // Ambiente Windows
$idLote = '';
$indSinc = '1';
$flagZip = false;
$retorno = $nfe->sefazEnviaLote($aXml, $tpAmb, $idLote, $aResposta, $indSinc, $flagZip);

//print_r($aResposta);
//No caso do Estado de SP eu Consigo Obter o Recibo como resposta, em Alagoas não, preciso estudar o funcionamento desses retornos
if ( $_SESSION["emitente"]["codigo_estado"] == 35){
  $recibo = $aResposta["nRec"];
  $retorno = $nfe->sefazConsultaRecibo($recibo, $tpAmb, $aResposta);
  //echo '<br><br><pre>';
  //echo htmlspecialchars($nfe->soapDebug);
  //echo '</pre><br><br><pre>';
  //print_r($aResposta);
  //echo "</pre><br>";
  //print_r($aResposta["aProt"]);

  if ($aResposta["aProt"][0]["cStat"]==100){
	$protocoloNfe  = $aResposta["aProt"][0]["nProt"];
	$motivo        = $aResposta["aProt"][0]["xMotivo"];
	$codigo_status = $aResposta["aProt"][0]["cStat"];
	$atualizaDadosNfe = mysqli_query($conexao,"update nota1 set recibo_nfe = '$recibo', protocolo_nfe = '$protocoloNfe', status = '$motivo', codigo_status_nfe =   '$codigo_status' where id = '$numero' and id_emitente = '$id_emitente'") or die(mysqli_error($conexao));
	echo "Nota Fiscal Transmitida com Sucesso!";
  }else{
    echo "Ocorreu o Seguinte erro ao Transmitir a NFe \n ".$aResposta["aProt"][0]["xMotivo"];	
  }	
}else{
//Para os Outros Estados deixei Padrão por enquanto até verificar novos problemas

//Primeiro Verifico se o Lote foi processado
if ($aResposta["cStat"] == 104){	
	//Depois verifico se a Nota foi Autorizada se foi autorizada Preencho os dados na Tabela
    if ($aResposta["prot"][0]["cStat"]==100){ 
	  $protocoloNfe  = $aResposta["prot"][0]["nProt"];
	  $motivo        = $aResposta["prot"][0]["xMotivo"];
	  $codigo_status = $aResposta["prot"][0]["cStat"];
	  $recibo        = '';
	  $atualizaDadosNfe = mysqli_query($conexao,"update nota1 set recibo_nfe = '$recibo', protocolo_nfe = '$protocoloNfe', status = '$motivo', codigo_status_nfe =        '$codigo_status' where id = '$numero' and id_emitente = '$id_emitente'") or die(mysqli_error($conexao));
	 
	  echo "Nota Fiscal Transmitida com Sucesso!";
   }else{
     echo "Ocorreu o Seguinte erro ao Transmitir a NFe \n ".$aResposta["prot"][0]["cStat"] .'-'. $aResposta["prot"][0]["xMotivo"];	
   }
  
 }else{
	echo "Não Foi possivel transmitir a Nota! \n Código do erro:".$aResposta["cStat"]. "\n Mensagem:" .$aResposta["xMotivo"];	
  if (array_key_exists("aProt", $aResposta)) {
    echo "\n Motivo: ".$aResposta["aProt"][0]["xMotivo"];
	exit; 
 }
 
 }
 }
 

// exit;
//echo '<br><br><pre>';
//echo htmlspecialchars($nfe->soapDebug);
//echo '</pre><br><br><pre>';
//print_r($aResposta);
//echo "</pre><br>";

//if ($aResposta["cStat"] = 104){
// $retorno = $nfe->addProtocolo($aXml, $xmlRetorno, true);
	
//}
// echo "Cstat = ".$aResposta["cStat"];


//  $recibo = $aResposta["nRec"];
//  $retorno = $nfe->sefazConsultaRecibo($recibo, $tpAmb, $aResposta);
//echo '<br><br><pre>';
//echo htmlspecialchars($nfe->soapDebug);
//echo '</pre><br><br><pre>';
//print_r($aResposta);


//echo "</pre><br>";

//print_r($aResposta["aProt"]);

  

//if ($aResposta["aProt"][0]["cStat"]==100){
//	$protocoloNfe  = $aResposta["aProt"][0]["nProt"];
//	$motivo        = $aResposta["aProt"][0]["xMotivo"];
//	$codigo_status = $aResposta["aProt"][0]["cStat"];
//	$atualizaDadosNfe = mysqli_query($conexao,"update nota1 set recibo_nfe = '$recibo', protocolo_nfe = '$protocoloNfe', status = '$motivo', codigo_status_nfe = //'$codigo_status' where id = '$numero' and id_emitente = '$id_emitente'") or die(mysqli_error($conexao));
//	echo "Nota Fiscal Transmitida com Sucesso!";
//}else{
//  echo "Ocorreu o Seguinte erro ao Transmitir a NFe \n ".$aResposta["aProt"][0]["xMotivo"];	
//}

//echo "Motivo".$aResposta["aProt"][0]["xMotivo"] . "CStat:".$aResposta["aProt"][0]["cStat"];//==100;
//print_r($aResposta["aProt"]);
