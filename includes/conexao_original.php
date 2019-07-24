<?php
	$db = "emissorn_sac";
	$conexao = mysqli_connect("localhost", "emissorn_andre", "tecno7788#") or trigger_error(mysql_error(),E_USER_ERROR);
	mysqli_select_db($conexao,$db); 	

?>