<?php
//Modelo retirado do Site
/*
http://sounoob.com.br/criando-uma-requisicao-de-pagamento-do-pagseguro-via-parametros-http-usando-php-sem-utilizar-a-biblioteca-oficial/
http://sounoob.com.br/recebendo-notificacoes-do-pagseguro-usando-php-sem-utilizar-a-biblioteca-oficial/
*/
if(isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction'){
    //Todo resto do código iremos inserir aqui.

    $email = 'net-solutions@hotmail.com';
    $token = 'D0C46EF0A1764CDFAF67C24954E2D460'; 
	//Notificação para testes: 4B0B18-851BB21BB26C-1FF40EAF97ED-E843AC

     $url = 'https://ws.pagseguro.uol.com.br/v2/transactions/notifications/' . $_POST['notificationCode'] . '?email=' . $email . '&token=' . $token;
 //   $url = 'https://ws.pagseguro.uol.com.br/v2/transactions/notifications/4B0B18-851BB21BB26C-1FF40EAF97ED-E843AC?email=' . $email . '&token=' . $token;

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $transaction= curl_exec($curl);
    curl_close($curl);

    if($transaction == 'Unauthorized'){
        //Insira seu código avisando que o sistema está com problemas, sugiro enviar um e-mail avisando para alguém fazer a manutenção
        mail("net-solutions@hotmail.com","ERRO NO PAGAMENTO","Verificar se está com algum problema no retoro dos pagamentos do Pagseguro, ou se o pagamento não foi autorizado");
        exit;//Mantenha essa linha
    }
    $transaction = simplexml_load_string($transaction);
	//var_dump($transaction);
	$status=$transaction->status;
	include "../includes/conexao.php";
	//Para atualizar o Registro correto pelo ID do Pedido usa-se
	$idPedido = $transaction->reference;  //esse valor tem que ter sido gerado no momento do pedido sendo Único na BD
   // $notificationCode = $_POST['notificationCode'];
    $Pedido = explode("-", $idPedido);
	$ano_vencimento = $pedido[0];
	$mes_vencimento = $pedido[1]; // Essa parte é a parte que contem o mês de vencimento do Emitente
	$id_emitente    = $pedido[2]; // Essa parte é a parte que contem o ID do Emitente
	mail("net-solutions@hotmail.com","Intenção de Pagamento","Segue a Notificação: $notificationCode Referencia: $idPedido, o CLiente com ID $id_emitente está manifestando interesse no pagamento da mensalidade referente ao mês $mes_vencimento e o ano $ano_vencimento");
	//Se o Pagamento foi Confirmado pelo Pagseguro
	if ($status==3){ //Verificar qual o retorno da transação concluída com sucesso!
      $gravar = mysqli_query($conexao,"update emitente set data_vencimento = ADDDATE( data_vencimento, INTERVAL 30 DAY) where id = $id_emitente");
	  mail("net-solutions@hotmail.com","Pagamento Efetivado","Segue a Notificação: $notificationCode Referencia: $idPedido, o CLiente com ID $id_emitente está manifestando interesse no pagamento da mensalidade referente ao mês $mes_vencimento e o ano $ano_vencimento verificar no PagSeguro se o Crédito está disponivel");
	}
}

?>
