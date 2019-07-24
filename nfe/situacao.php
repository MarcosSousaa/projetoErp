<?php
  session_start();  
  include_once("../includes/conexao.php");
  @$tabela              = 'nota1';
  @$numero              = $_GET['id'];
  @$id_emitente         = $_SESSION["usuario"]["id"];

 $situacao = mysqli_query($conexao,"select cancelada, codigo_status_nfe from nota1 where id_emitente ='$id_emitente' and id = '$numero'")or die(mysqli_error($conexao)); $sitnota = mysqli_fetch_array($situacao); 
	
	if ($sitnota["cancelada"] == 'S' ){
		echo "0"; //Cancelada		
	}else if ($sitnota["codigo_status_nfe"] == 100) {
		echo "1";	//Transmitida
	}else{
	  echo "2";	
	}
?>