<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../nfephp/bootstrap.php';
$id_emitente   = $_SESSION["usuario"]["id"];

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe('../nfephp/config/config'.$id_emitente.'.json');
$nfe->setModelo('55');
include_once("../includes/conexao.php");

$numero = $_POST["numero_nota"];
$pegaChavenoBD2 = mysqli_query($conexao,"select chave_nfe from nota1 where id = '$numero' and id_emitente = '$id_emitente'");
$pegaChavenoBD = mysqli_fetch_array($pegaChavenoBD2);
$chave = $pegaChavenoBD["chave_nfe"];
//$chave = '35161047265798000167550010000000141000000149';
$tpAmb = $_SESSION["ambiente"];
$aResposta = array();
$xml = $nfe->sefazConsultaChave($chave, $tpAmb, $aResposta);
//echo '<br><br><pre>';
//echo htmlspecialchars($nfe->soapDebug);
//echo '</pre><br><pre>';
//print_r($aResposta);
echo "Código: ".$aResposta["cStat"]."\n Situação:".$aResposta["xMotivo"];
//echo "<pre><br>";
