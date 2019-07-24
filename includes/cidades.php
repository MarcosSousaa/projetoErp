<?php
include_once "conexao.php";

$estado = $_POST['estado'];


$sql = "SELECT * FROM cidades WHERE codigo_estado = '$estado' ORDER BY nome_cidade ASC";
$qr = mysqli_query($conexao,$sql) or die(mysqli_error());

if(mysqli_num_rows($qr) == 0){
   echo  '<option value="0">'.htmlentities('Não há cidades nesse estado').'</option>';
   
}else{
   while($ln = mysqli_fetch_assoc($qr)){
      echo '<option value="'.$ln['codigo_cidade'].'">'.$ln['nome_cidade'].'</option>';
   }
}
