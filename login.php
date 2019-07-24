<?php
	session_start();
	include_once('includes/conexao.php');
	include_once('includes/funcoes.php');
	try{
	  	$login = anti_sql_injection($_POST['email']); 
	  	$pass = anti_sql_injection($_POST['senha']);  
	  	$VerificaLogin = mysqli_query($conexao,"select * from emitente where email = '$login' and senha = '$pass'");
	  	if (mysqli_num_rows($VerificaLogin)>0){
	    	$_SESSION["usuario"] = mysqli_fetch_array($VerificaLogin);
			echo "1";
	  	}else{
		    echo "0";
	  	}	
	}catch (Exception $e){
		echo "0";  
  	}
?>
