<?php
	$db = "sac";
	$conexao = mysqli_connect("localhost", "root", "") or trigger_error(mysql_error(),E_USER_ERROR);
	mysqli_select_db($conexao,$db); 	

?>