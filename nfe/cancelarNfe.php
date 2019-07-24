<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../nfephp/bootstrap.php';
$id_emitente   = $_SESSION["usuario"]["id"];

use NFePHP\NFe\ToolsNFe;

//$nfe = new ToolsNFe('../../config/config.json');
//$nfe = new ToolsNFe('../nfephp/config/config.json');
$nfe = new ToolsNFe('../nfephp/config/config'.$id_emitente.'.json');
$nfe->setModelo('55');

$aResposta = array();
//$chave = '35150158716523000119550010000000071000000076';
//$nProt = '135150000408219';
include_once("../includes/conexao.php");

$numero = $_POST["numero_nota"];
$motivoCancelamento = $_POST["motivoCancelamento"];
$pegaChavenoBD2 = mysqli_query($conexao,"select chave_nfe, protocolo_nfe from nota1 where id = '$numero' and id_emitente = '$id_emitente'");
$pegaChavenoBD = mysqli_fetch_array($pegaChavenoBD2);
$chave = $pegaChavenoBD["chave_nfe"];
$nProt = $pegaChavenoBD["protocolo_nfe"];
$tpAmb = $_SESSION["ambiente"];
$xJust = $motivoCancelamento;
$retorno = $nfe->sefazCancela($chave, $tpAmb, $xJust, $nProt, $aResposta);

//echo '<br><br><PRE>';
//echo htmlspecialchars($nfe->soapDebug);
//echo '</PRE><BR>';
//print_r($aResposta);
//echo "<br>";


if ($aResposta["cStat"] != 100){	
	 if (array_key_exists("evento", $aResposta)) {
       echo "\n Motivo: ".$aResposta["evento"][0]["xMotivo"];
	   exit;
     }
	$atualizaDadosNfe = mysqli_query($conexao,"update nota1 set cancelada = 'S' where id = '$numero' and id_emitente = '$id_emitente'") or die(mysqli_error($conexao));
	echo "Nota Fiscal Cancelada com Sucesso!";
}else{
  echo "Ocorreu o Seguinte erro ao Cancelar a NFe \n ".$aResposta["xMotivo"];	
}
