<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../nfephp/bootstrap.php';
$id_emitente   = $_SESSION["usuario"]["id"];

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe('../nfephp/config/config'.$id_emitente.'.json');
include_once("../includes/conexao.php");
$numero = $_POST["numero_nota"];
$pegaChavenoBD2 = mysqli_query($conexao,"select chave_nfe from nota1 where id = '$numero'");
$pegaChavenoBD = mysqli_fetch_array($pegaChavenoBD2);
$chave = $pegaChavenoBD["chave_nfe"];
// $filename = "/var/www/nfe/homologacao/entradas/{$chave}-nfe.xml"; // Ambiente Linux
$filename = "arquivos/$id_emitente/entradas/{$chave}-nfe.xml"; // Ambiente Windows
$xml = file_get_contents($filename);
$xml = $nfe->assina($xml);
// $filename = "/var/www/nfe/homologacao/assinadas/{$chave}-nfe.xml"; // Ambiente Linux
$filename = "arquivos/$id_emitente/entradas/{$chave}-nfe.xml"; // Ambiente Windows
file_put_contents($filename, $xml);
chmod($filename, 0777);
echo $chave;
