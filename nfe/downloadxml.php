<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../nfephp/bootstrap.php';
$id_emitente   = $_SESSION["usuario"]["id"];

use NFePHP\NFe\ToolsNFe;

//$nfe = new ToolsNFe('../../config/config.json');
$nfe = new ToolsNFe('../nfephp/config/config'.$id_emitente.'.json');
$nfe->setModelo('55');



$chNFe= $_GET["chave_nfe"];
$tpAmb = '1'; //1 = Produção 2 = Homologação
$cnpj = $_GET["cnpj"];
$aResposta = array();

$resp = $nfe->sefazDownload($chNFe, $tpAmb, $cnpj, $aResposta);
//echo '<br><br><PRE>';
//echo htmlspecialchars($nfe->soapDebug);
//echo '</PRE><BR>';
//print_r($aResposta);
//echo "<br>";

echo $aResposta["xMotivo"];
