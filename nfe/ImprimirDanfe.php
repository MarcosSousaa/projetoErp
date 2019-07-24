<?php
session_start();
/**
 * ATENÇÃO : Esse exemplo usa classe PROVISÓRIA que será removida assim que 
 * a nova classe DANFE estiver refatorada e a pasta EXTRAS será removida.
 */

error_reporting(E_ALL);
ini_set('display_errors', 'On');
$id_emitente   = $_SESSION["usuario"]["id"];

require_once '../nfephp/bootstrap.php';

use NFePHP\NFe\ToolsNFe;
use NFePHP\Extras\Danfe;
use NFePHP\Common\Files\FilesFolders;

//$nfe = new ToolsNFe('../nfephp/config/config.json');
$nfe = new ToolsNFe('../nfephp/config/config'.$id_emitente.'.json');
include_once("../includes/conexao.php");
$numero = $_GET["numero_nota"];
$pegaChavenoBD2 = mysqli_query($conexao,"select chave_nfe from nota1 where id = '$numero'");
$pegaChavenoBD = mysqli_fetch_array($pegaChavenoBD2);
$chave = $pegaChavenoBD["chave_nfe"];
//$chave = '35161047265798000167550010000000141000000149';
//$xmlProt = "D:/xampp/htdocs/GIT-nfephp-org/nfephp/xmls/NF-e/homologacao/enviadas/aprovadas/201605/{$chave}-protNFe.xml";
$xmlProt = "../nfe/arquivos/$id_emitente/entradas/{$chave}-nfe.xml"; // Ambiente Windows
// Uso da nomeclatura '-danfe.pdf' para facilitar a diferenciação entre PDFs DANFE e DANFCE salvos na mesma pasta...
$pdfDanfe = "../nfe/arquivos/$id_emitente/entradas/{$chave}-danfe.pdf";
//$pdfDanfe = "D:/xampp/htdocs/GIT-nfephp-org/nfephp/xmls/NF-e/homologacao/pdf/201605/{$chave}-danfe.pdf";

$docxml = FilesFolders::readFile($xmlProt);
$danfe = new Danfe($docxml, 'P', 'A4', $nfe->aConfig['aDocFormat']->pathLogoFile, 'I', '');
$id = $danfe->montaDANFE();
$salva = $danfe->printDANFE($pdfDanfe, 'F'); //Salva o PDF na pasta
$abre = $danfe->printDANFE("{$id}-danfe.pdf", 'I'); //Abre o PDF no Navegador
