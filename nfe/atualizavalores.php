<?php
  session_start();
  include_once("../includes/conexao.php");
  $id_emitente   = $_SESSION["usuario"]["id"];
  $numero = $_GET["id"];
  $valordosprodutos = mysqli_query($conexao,"select valor_produtos from nota1 where id_nota = '$numero' and id_emitente = '$id_emitente'");
  $totalprodutos = mysqli_fetch_array($valordosprodutos);
  extract($totalprodutos);
  echo json_encode($totalprodutos);

?>