<?php    
    session_start();
	include("../includes/conexao.php");
	$id_emitente   = $_SESSION["usuario"]["id"];
	$diretorio = '../nfephp/certs/'.$id_emitente;
	
	$arquivo = isset($_FILES['arquivo']) ? $_FILES['arquivo'] : FALSE;
	

	try {	
	  $nomeArquivo = $diretorio . '/certificado.pfx';
      move_uploaded_file($arquivo['tmp_name'], $nomeArquivo);
   	 echo "success"; 					
	 }catch (Exception $e) {
	     echo $e->getMessage();
	     exit;
     }
	

?>