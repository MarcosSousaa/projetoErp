<?php
  session_start();
  $de  = date('Y-m-d', strtotime($_POST["de"]));
  $ate = date('Y-m-d', strtotime($_POST["ate"]));
  $id_cliente = $_POST["id_cliente"];
  $nfe = $_POST["nfe"]; // 0=Todas  1=Transmitidas  2=Canceladas
  if ($id_cliente <> ""){
	  $cliente = "and id_cliente = '$id_cliente'";
  }else{
	 $cliente = ""; 
  }
  switch ($nfe){
    case '0' : $tiponfe = " and codigo_status_nfe = 100 or cancelada = 'S'"; break;
	case '1' : $tiponfe = " and cancelada = 'N' and codigo_status_nfe = 100"; break;
	case '2' : $tiponfe = " and cancelada = 'S'"; break;	  
  }
  include_once("../includes/conexao.php");
  include '../nfephp/vendor/mpdf/mpdf/mpdf.php';
  
  $notas = mysqli_query($conexao, "select * from nota1 where emissao between '$de' and '$ate' $cliente $tiponfe"); 
  
  $mpdf=new mPDF();
  $saida = 
        '<html>
		   <head>
		     <style rel="stylesheet" type="text/css">
			   body{
				   margin:0;
				   padding:0;
				   line-height:40%;  
				   font-family:calibri;
	               font-size:12px;  
			   }
			  p{
	            font-family:calibri;
	            font-size:11px;  
              }
			 </style>
		   </head>
            <body>
			<p align="left">Relatório de Notas Fiscais Transmitidas</p>
			<p align="left">Periodo de '.$_POST["de"].' até '.$_POST["ate"].' Cliente: '.$cliente.'</p>
	<br />	
				
	 <table border="1px" height="500" cellpadding="5px" cellspacing="0" width="100%">
     <tr> 
       <th width="50" align="left">Nº</th> 
	   <th width="100" align="left">Emissão</th>     
       <th width="100" align="left">Cliente</th>
       <th width="250" align="left">Valor Total</th>
	   <th width="250" align="left">Situação</th>
     </tr>
';


    while ($row = mysqli_fetch_array($notas)) { 
      $emissao  = $row["emissao"];
      $numero   = $row["numero_nota"];
      $nome     = $row['nome_cliente'];
	  $valor    = $row['valor_total'];
	  $situacao = $row['status'];

     $saida = $saida."  
	  <tr> 
        <td width=\"50\" align=\"left\">$numero</td>
        <td width=\"100\" align=\"left\"><label>$emissao</label></td>
	    <td width=\"250\" align=\"left\">$nome</td>	  
	    <td width=\"100\" align=\"left\">$valor</td>	  
        <td align=\"left\">$situacao</td>
      </tr>";

  }

$saida = $saida. "
</table>
<br />

<hr width=\"100%\">
<div style=\"float:left;width:70%\">Usuário: ".$_SESSION["emitente"]["nome"]."</div>
<div style=\"float:right;width:20%\">Data: ".date("d-m-Y")."	</div>			
                
				
            </body>
        </html>
        ";

$arquivo = "relatorio de Notas.pdf";

//$mpdf = new mPDF();
//$mpdf->WriteHTML($saida);
/*
 * F - salva o arquivo NO SERVIDOR
 * I - abre no navegador E NÃO SALVA
 * D - chama o prompt E SALVA NO CLIENTE
 */

//$mpdf->Output($arquivo, 'I');

$mpdf->WriteHTML($saida);
$mpdf->Output($arquivo,'I');
// echo $saida;
  
?>