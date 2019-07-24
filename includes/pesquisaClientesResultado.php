<?php 
  session_start(); 
  include_once "conexao.php";
  $tabela = 'clientes';  

  if (isset($_GET["busca"])){
	  $busca = $_GET["busca"];
	  if (empty($busca)){
		  $select2 = "and 1 = -1";
	  }else{          		  
		  $select2 = "and upper(nome) like upper('%$busca%') limit 7"; 		  
	  }
  }else{
	$select2 = "and 1 = -1";	
	}
  // Select que traz todos os usuario cadastrados no banco de dados
  @$id_emitente   = $_SESSION["usuario"]["id"];	
  $select = "select * from clientes where id_emitente = '$id_emitente' ". $select2;
  
  
?>
<table class="lista-clientes" width="100%">
        <thead>
            <tr>
                <th align="center" width="5%">Código</th>
                <th>Descrição</th>                
            </tr>
        </thead>
        <tbody>
        <?php
		  $result = mysqli_query($conexao,$select);//$pdo->query($select);
            //Enquanto existir usuários no banco ele insere uma nova linha e exibe os dados
          while ($row = mysqli_fetch_array($result)) { 
		  echo '
		    <tr class="tabelaPesquisaClientes">
                <td align="center" data-id="'.$row["id"].'">'.$row["id"].'</td>
                <td data-nome="'.$row["nome"].'">'.$row["nome"].'</td>
            </tr>
		  ';
		  }
		?>
            
          
        </tbody>
    </table>
