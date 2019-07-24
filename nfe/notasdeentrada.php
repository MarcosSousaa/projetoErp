<LINK rel="stylesheet"  HREF="estilo.css"  TYPE="text/css">
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
$id_emitente   = $_SESSION["usuario"]["id"];
require_once '../nfephp/bootstrap.php';

use NFePHP\NFe\ToolsNFe;

//$nfe = new ToolsNFe('../../config/config.json');
$nfe = new ToolsNFe('../nfephp/config/config'.$id_emitente.'.json');

$nfe->setModelo('55');

$ultNSU = 0; // se estiver como zero irá retornar os dados dos ultimos 15 dias até o limite de 50 registros
             // se for diferente de zero irá retornar a partir desse numero os dados dos
             // últimos 15 dias até o limite de 50 registros

$numNSU = 0; // se estiver como zero irá usar o ultNSU
             // se for diferente de zero não importa o que está contido em ultNSU será retornado apenas
             // os dados deste NSU em particular

$tpAmb = '1';// esses dados somente existirão em ambiente de produção pois em ambiente de testes
             // não existem dados de eventos, nem de NFe emitidas para o seu CNPJ

$cnpj = ''; // deixando vazio irá pegar o CNPJ default do config
            // se for colocado um CNPJ tenha certeza que o certificado está autorizado a
            // baixar os dados desse CNPJ pois se não estiver autorizado haverá uma
            // mensagem de erro da SEFAZ

//array que irá conter os dados de retorno da SEFAZ
$aResposta = array();

//essa rotina deve rá ser repetida a cada hora até que o maxNSU retornado esteja contido no NSU da mensagem
//se estiver já foram baixadas todas as referencias a NFe, CTe e outros eventos da NFe e não a mais nada a buscar
//outro detalhe é que não adianta tentar buscar dados muito antigos o sistema irá informar que 
//nada foi encontrado, porque a SEFAZ não mantêm os NSU em base de dados por muito tempo, em 
//geral são mantidos apenas os dados dos últimos 15 dias.
//Os dados são retornados em formato ZIP dento do xml, mas no array os dados 
//já são retornados descompactados para serem lidos
$xml = $nfe->sefazDistDFe('AN', $tpAmb, $cnpj, $ultNSU, $numNSU, $aResposta);

//echo '<br><br><PRE>';
//echo htmlspecialchars($nfe->soapDebug);
//echo '</PRE><BR>';
//Faço a listagem dos dados da NFe
//echo "Eu Separando os Itens da NFe<br>";

//print_r($aResposta);
//exit;
 echo '<table width="100%" border="0" cellpadding="1" cellspacing="1">
    <tr class="cor0">
      <td  align="center" width="0%">GERAL</td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="1" cellspacing="1">
    <tr class="cor0">
      <td align="center">Chave de Acesso da NFE</td>
      <td align="center">Prot. Autorizacao de uso</td>
      <td  align="center">Numero Nota</td>      
      <td  align="center">Data Emissao</td>
	  <td  align="center">CNPJ EMITENTE</td>
	  <td  align="center">Último NSU</td>
	  <td  align="center">Manifestação</td>
    </tr>';
if ($aResposta['cStat'] == '138') {  // verifica se a consulta foi um sucesso
  $i = 0;
  while ($i < count($aResposta['aDoc'])) {
     $ultNSU = $aResposta['aDoc'][$i]['NSU'];  // recebe o ultimo NSU de cada consulta
   //  if ($aResposta['aDoc'][$i]['schema'] == 'procNFe_v3.10.xsd') {
         $arrs = simplexml_load_string($aResposta['aDoc'][$i]['doc']);
     // print_r($arrs);
	  @$s =  (string) $arrs->evento->infEvento->detEvento->descEvento;  
	 // print_r($s);
      $manifestacao = $s;
	  $chNfe = (string) $arrs->chNFe;
	  $cnpjEmit = (string) $arrs->CNPJ;
	  $nProt = (string) $arrs->nProt;
	  $dataEmissao = explode('T', (string) $arrs->dhEmi);
      if (trim($chNfe) == ''){
		$chNfe    = (string) $arrs->evento->infEvento->chNFe; 
		$cnpjEmit = (string) $arrs->evento->infEvento->CNPJ;	
		$dataEmissao = explode('T', (string) $arrs->evento->infEvento->dhEvento);
		$permitedownload = true;
	  }else{
		 $permitedownload = false;
	    $manifestacao = "Não Manifestada";	  
	  }
	  //Verifico se vai ter o link para download
	  if ($permitedownload){
	    $linkchave = '<a href="downloadxml.php?chave_nfe='.$chNfe.'&cnpj='.$cnpjEmit.'">'. $chNfe . '</a>';
	  }else{
		$linkchave = $chNfe;  
	  }
  echo'
   <tr class="cor1">
      <td  align="left" width="0%">'.$linkchave.'</td>
      <td  align="center" width="0%"><input type="text" name="protocolo" size="15" class="cor1" title="Protocolo de autorização da NFe" value="'.$nProt.'" readonly="readonly" /></td>
	  <td  align="center" width="0%"><input type="text" name="serie" size="3" class="cor1" value="'.substr($chNfe,26,9).'" readonly="readonly"	 /></td>
      <td  align="center" width="0%"><input type="text" name="nNF" size="10" class="cor1" value="'.$dataEmissao[0].'" readonly="readonly" /></td>      
      <td  align="center" width="0%"><input type="text" name="dt_emissao" size="14" class="cor1" value="'.$cnpjEmit.'" readonly="readonly" /></td>
	  <td  align="center" width="0%"><input type="text" name="dt_emissao" size="15" class="cor1" value="'.$ultNSU.'" readonly="readonly" /></td>
	  <td  align="center" width="0%"><input type="text" name="dt_emissao" size="25" class="cor1" value="'.$manifestacao.'" readonly="readonly" /></td>
    </tr>
';
		
//	 }
	  $i++;
	 
  }
}
echo "</table>";
