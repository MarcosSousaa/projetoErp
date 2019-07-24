<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../nfephp/bootstrap.php';
@$id_emitente   = $_SESSION["usuario"]["id"];
@$emailcliente  = $_POST["email"];

//NOTA: o envio de email com o DANFE somente funciona para modelo 55
//      o modelo 65 nunca requer o envio do DANFCE por email

use NFePHP\NFe\ToolsNFe;

//$nfe = new ToolsNFe('../../config/config.json');
$nfe = new ToolsNFe('../nfephp/config/config'.$id_emitente.'.json');
$nfe->setModelo('55');
include_once("../includes/conexao.php");
$numero = $_POST["numero_nota"];
$pegaChavenoBD2 = mysqli_query($conexao,"select chave_nfe from nota1 where id_nota = '$numero'");
$pegaChavenoBD = mysqli_fetch_array($pegaChavenoBD2);
$chave = $pegaChavenoBD["chave_nfe"];
//$chave = '52160500067985000172550010000000101000000100';
$pathXml = "arquivos/$id_emitente/entradas/{$chave}-nfe.xml"; // Ambiente Windows
//$pathXml = "D:/xampp/htdocs/GIT-nfephp-org/nfephp/xmls/NF-e/homologacao/enviadas/aprovadas/201605/{$chave}-protNFe.xml";
$pathPdf = "arquivos/$id_emitente/entradas/{$chave}-danfe.pdf";
//$pathPdf = "D:/xampp/htdocs/GIT-nfephp-org/nfephp/xmls/NF-e/homologacao/pdf/201605/{$chave}-danfe.pdf";

 


//Faz o Envio do Email com os Anexos
  if (file_exists($pathXml) and file_exists($pathPdf)){
	  
   $assunto = 'NFe - '. $_SESSION["usuario"]["nome"];  
   $mensagem = 'Segue anexo o XML e o PDF da NFe com a chave '. $chave;
   
   $boundary = "XYZ-" . date("dmYis") . "-ZYX";
   $mens  = "--$boundary\n";	
   $mens .= "Content-Transfer-Encoding: 8bits\n";
   $mens .= "Content-Type: text/html; charset=\"ISO-8859-1\"\n\n"; 
   $mens .= "$mensagem\n";
   $mens .= "--$boundary\n";	  
	  
//Inicio dos Anexos	  
	//Anexo o XML  
   $fp = fopen($pathXml, "rb");
   $anexo = chunk_split(base64_encode(fread($fp, filesize($pathXml))));		 
   fclose($fp);
   $mens .= "Content-Type: XML\n name=\"{$chave}-nfe.xml\"\n";
   $mens .= "Content-Disposition: attachment; filename=\"{$chave}-nfe.xml\"\n";		
   $mens .= "Content-transfer-encoding:base64\n\n"; 
   $mens .= $anexo."\n";
   $mens.= "--$boundary\n";
   
   
   //Anexo o PDF
   $fp2 = fopen($pathPdf, "rb");
   $anexo2 = chunk_split(base64_encode(fread($fp2, filesize($pathPdf))));		 
   fclose($fp2);
   $mens .= "Content-Type: PDF\n name=\"{$chave}-danfe.pdf\"\n";
   $mens .= "Content-Disposition: attachment; filename=\"{$chave}-danfe.pdf\"\n";		
   $mens .= "Content-transfer-encoding:base64\n\n"; 
   $mens .= $anexo2."\n";
   $mens.= "--$boundary--";     
//Fim dos Anexos   

 $headers  = "MIME-Version: 1.0\n";
 $headers .= "Date: ".date("D, d M Y H:i:s O")."\n";
 $headers .= "From: \"Remetente\" <$emailcliente>\r\n";
 $headers .= "Content-type: multipart/mixed; boundary=\"$boundary\"\r\n";


 if(mail($emailcliente, $assunto, $mens, $headers)){
   echo "O email foi enviado com sucesso!";
  } else {
    echo "Nao foi possivel enviar o email";
  }	
}
//Fim do envio do email


//$aMails = array($emailcliente); //se for um array vazio a classe Mail irá pegar os emails do xml
//$templateFile = ''; //se vazio usará o template padrão da mensagem
//$comPdf = true; //se true, anexa a DANFE no e-mail
//echo "PDF: $pathPdf XML: $pathXml"; 




//try {
//    $nfe->enviaMail($pathXml, $aMails, $templateFile, $comPdf, $pathPdf);
//    echo "DANFE enviada com sucesso!!!";
//} catch (NFePHP\Common\Exception\RuntimeException $e) {
//	echo "PDF: $pathXml XML: $pathXml"; 
 //   //echo $e->getMessage();
//}