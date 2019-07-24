<?php
	session_start();
	//Referencia será formada pelo Ano e mês referencia da parcela seguida do ID do emitente
	$ex = explode("-", $_SESSION["emitente"]["data_vencimento"]);
	$ano    = $ex[0];
	$mes    = str_pad($ex[1], 2, '0', STR_PAD_LEFT);
	$codRef = $ano.'-'.$mes.'-'.$_SESSION["emitente"]["id"];
	$data['token'] ='D0C46EF0A1764CDFAF67C24954E2D460';
	$data['email'] = 'net-solutions@hotmail.com';
	$data['currency'] = 'BRL';
	$data['itemId1'] = '1';
	$data['itemQuantity1'] = '1';
	$data['itemDescription1'] = "Mensalidade  REF. ao mes $mes de $ano do Emissor NFE";
	$data['itemAmount1'] = '19.00';
	$data['reference'] = $codRef;
	$data['senderName'] = $_SESSION["emitente"]["nome"];
	//$data['senderAreaCode'] = '11';
	//$data['senderPhone'] = '56273440';
	$data['senderEmail'] = $_SESSION["emitente"]["email"];
	$data['shippingType'] = '1';
	$data['shippingAddressStreet'] = $_SESSION["emitente"]["endereco"];
	$data['shippingAddressNumber'] = $_SESSION["emitente"]["numero"];
	$data['shippingAddressComplement'] = $_SESSION["emitente"]["complemento"];
	$data['shippingAddressDistrict'] = $_SESSION["emitente"]["bairro"];
	$data['shippingAddressPostalCode'] = $_SESSION["emitente"]["cep"];
	$data['shippingAddressCity'] = $_SESSION["emitente"]["nome_cidade"];
	$data['shippingAddressState'] = $_SESSION["emitente"]["nome_estado"];
	$data['shippingAddressCountry'] = 'BRA';
	//$data['redirectURL'] = 'http://www.sounoob.com.br/paginaDeAgracedimento'; 

	$url = 'https://ws.pagseguro.uol.com.br/v2/checkout';

	$data = http_build_query($data);

	$curl = curl_init($url);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	$xml= curl_exec($curl);

	curl_close($curl);

	$xml= simplexml_load_string($xml);
	echo  $xml -> code;
	//echo $codRef . "Data:".$_SESSION["emitente"]["data_vencimento"];  //Teste da geração do Código de Referencia
?>
