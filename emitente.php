<?php
  session_start();
  include_once("includes/conexao.php");
  @$id_emitente   = $_SESSION["usuario"]["id"];
  $dadosEmitente = mysqli_query($conexao,"select * from emitente where id = '$id_emitente'");
  $_SESSION["emitente"] =  mysqli_fetch_array($dadosEmitente);
  $_SESSION["ambiente"] = 2;  //1= Produção e 2= Homologação

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Painel Administrativo</title>
    <link rel="stylesheet" type="text/css" href="includes/estilo.css" />
    <link rel="stylesheet" type="text/css" href="includes/estiloBotoes.css" />
    <script type="text/javascript" src="includes/jquery.js"></script>
    <script type="text/javascript" src="includes/jquery-ui.js"></script>
    <script type="text/javascript" src="includes/meiomask.js"></script>
    <script type="text/javascript">	
      $(document).ready(function() 
      {    
        function AbreCobranca(tipo){
  	      //Tipo 1 = Aviso mas permite continuar usando o Sistema
  	      //Tipo 2 = Bloqueia o Sistema permitindo apenas entrar em contato pelo CHAT ou efetuar o Pagamento pelo Pagseguro
		      if (tipo == 1)
          {			
            var id = "#cobranca";//$(this).attr("href");
		      }else
          {
		        var id = "#bloqueio";//$(this).attr("href");
		      }
          var alturaTela = $(document).height();
          var larguraTela = $(window).width();
          //colocando o fundo preto
          $('#mascara').css({'width':larguraTela,'height':alturaTela});
          $('#mascara').fadeIn(1000); 
          $('#mascara').fadeTo("slow",0.8);
          var left = ($(window).width() /2) - ( $(id).width() / 2 );
          var top = ($(window).height() / 2) - ( $(id).height() / 2 );
          $(id).css({'top':top,'left':left});
          $(id).show();   
        };
        //  $("#mascara").click( function(){
        //      $(this).hide();
        //      $(".window").hide();
        //  });
        $('.fechar').click(function(ev)
        {
          ev.preventDefault();
          $("#mascara").hide();
          $("#cobranca").hide();
        });
	      //Abro o Aviso de Pagamento caso vencido e Bloqueio o Sistema se vencido com mais de 10 dias
	      <?php
          $vencimento         = $_SESSION["emitente"]["data_vencimento"];
	        $vencimentocarencia = date('Y-m-d', strtotime("+10 days",strtotime($vencimento))); 
	        $dataAtual          = date('Y-m-d');
          // Comparando as Datas
          if(strtotime($dataAtual) > strtotime($vencimentocarencia) ) 
          {
            echo 'AbreCobranca(2);';  
          }
          else if(strtotime($dataAtual) > strtotime($vencimento)) 
          {
		        echo 'AbreCobranca(1);';	   	 
	        }
          echo "//// Vencimento $vencimento  Carencia $vencimentocarencia Data Atual $dataAtual ";
        ?>
        function dataAtualFormatada()
        {
          var data = new Date();
          var dia = data.getDate();
          if (dia.toString().length == 1)
            dia = "0"+dia;
          var mes = data.getMonth()+1;
          if (mes.toString().length == 1)
            mes = "0"+mes;
          var ano = data.getFullYear();  
          return dia+"/"+mes+"/"+ano;
        }
        $('#VerificaStatus').click(function()
        {
          $.post('nfe/status.php', function(resposta)
          {
            alert(resposta);			
		      });
		    });
		    $('#ConsultaNfe').click(function()
        {
          $.post('nfe/consultanfe.php', function(resposta)
          {				 			
		      });
		    });
		    $('#NovaNota').click(function(){
  			  //$.post('nfe/iniciarNfe.php', function(resposta){
  		    $.getJSON('nfe/iniciarNfe.php', function(resposta)
          {
            if (resposta.id != 0)
            {
              $('#numero').val(resposta.id);	
              $('#id_nota').val(resposta.id_nota);
              $('#emissao').val(dataAtualFormatada);
              $('#saida').val(dataAtualFormatada);		 
              $('#natureza').val('VENDA DE MERCADORIA');
              //Limpa Campos
              $('#id_cliente	').val("");
              $('#nome_cliente').val("");
              $('#inf_ad_contribuinte').val("");
              $('#inf_ad_fisco').val("");
              $('#natureza').focus();
  		      }else
            {
              alert("ERRO AO TENTAR CRIAR NOVA NFE");	
  			    }
          });
        });		 
		    $("#EfetuarPagamento, #EfetuarPagamento2").on('click', function(e) 
        {
          e.preventDefault();	
          $.post('pagseguro.php','',function(data)
          {
            $('#code').val(data);
            $('#pagarMensalidade').submit();
          })
        })		 
    });
    </script>        
  </head>
  <body>
    <div class="global-div">
      <h1>EmissorNfe.net</h1>
      <div id="Menu">
        <a href="emitente.php">
          <img src="imgs/home.png" title="Ir para Página Principal"/>
        </a>  
        <a href="?acao=Clientes">
          <img src="imgs/clientes.png" width="48" height="48" title="Clientes" />
        </a>
        <a href="?acao=Transportadoras">
          <img src="imgs/transportadoras.png" width="48" height="48" title="Transportadoras" />
        </a>
        <a href="?acao=Produtos">
          <img src="imgs/produtos.png" width="48" height="48" title="Produtos" />
        </a>
        <a href="?acao=NFe">
          <img src="imgs/nfe.png" width="48" height="48" title="Emissão de NFe" />
        </a>
        <a href="nfe/notasdeentrada.php">
          <img src="imgs/nfe.png" width="48" height="48" title="Emissão de NFe" />
        </a>
        <a href="?acao=Relatorios"><img src="imgs/relatorios.png" width="48" height="48" title="Relatórios de NFe" /></a>
        <a href="?acao=EnviarXmls">
          <img src="imgs/arquivos.png" width="48" height="48" title="Envio de XMls" />
        </a>
        <a href="?acao=Parametros">
          <img src="imgs/parametros.png" width="48" height="48" title="Configurações do Destinatário" />
        </a>
        <a href="encerrar.php">
          <img src="imgs/sair.png" width="48" height="48" />
        </a>
      </div>
      <div id="conteudo">
        <?php
          if(isset($_GET["acao"]))
          {
        	  switch($_GET["acao"])
            {
          		case 'Clientes' : $incluir = 'clientes/index.php';  break;
          		case 'Transportadoras' : $incluir = 'transportadoras/index.php';  break;
          		case 'Produtos' : $incluir = 'produtos/index.php';  break;
          		case 'NFe' : $incluir = 'nfe/index.php';  break;
          		case 'Parametros' : $incluir = 'emitente/index.php';  break;
          		case 'Relatorios' : $incluir = 'nfe/relatorios.php';  break;
          		case 'EnviarXmls' : $incluir = 'nfe/enviarmultiplosxmls.php';  break;
          		//case 'EnviarXmls' : $incluir = 'nfe/enviarmultiplosxmls.php';  break;
            }
          }else
          {
            $incluir = "conteudo.php";  
          }
          include "$incluir";
        ?>
      </div>
      <p class="credito">Desenvolvido por 
        <a href="http://www.opiniaodetudo.com" title="Desenvolvido por André Luiz G. de Macedo">André Luiz Gonçalves de Macedo
        </a>
      </p>
    </div>
    <div id="mascara"></div>
    <div id="sucesso" title="Sucesso" style="display:none">
      <p>Cadastro Efetuado com Sucesso.</p>
    </div>
    <div id="statusServico" title="Status do Serviço" style="display:none">
      <p>Cadastro Efetuado com Sucesso.</p>
    </div>
    <div id="chat">
      <script language="JavaScript" src="http://netsolutions.techinsyscursos.com.br/atendimento//js/status_image.php?base_url=http://netsolutions.techinsyscursos.com.br/atendimento/&l=netsolutions&x=1&deptid=0&"><a href="/atendimento//setup/code.php"></a>
      </script>
    </div>
    <div class="avisopagamento" id="cobranca">
      <a href="#" class="fechar">X Fechar</a>
      <h2 style="color:#D8BD31">Aviso de Pagamento</h2>
      <p>
        Ainda não identificamos o Pagamento da Sua mensalidade, não corra o risco de ficar sem emitir as suas NFes
      </p>
      <p>
        <input type="button" value="Pagar Mensalidade" class="but" id="EfetuarPagamento" >
      </p>
      <form id="pagarMensalidade" action="https://pagseguro.uol.com.br/checkout/v2/payment.html" method="post" onsubmit="PagSeguroLightbox(this); return false;">
        <input type="hidden" name="code" id="code" value="" />
      </form>
    </div>
    <div class="Bloqueiopagamento" id="bloqueio">
      <h2 style="color:#D52023">Sistema Bloqueado</h2>
      <p>
        Como até o momento ainda não identificamos o pagamento da mensalidade do seu sistema, ele está bloqueado até a confirmação do Pagamento, caso o pagamento já tenha sido efetuado entre em contato conosco para verificarmos o problema
      </p>
      <p>
        <a href="http://netsolutions.techinsyscursos.com.br/atendimento//request.php?l=netsolutions&amp;x=1&amp;deptid=0&amp;page=http//www.sistemasnetsolutions.com.br/">Atendimento Online
        </a>
        <input type="button" value="Pagar Mensalidade" class="but" id="EfetuarPagamento2" >
      </p>
      <script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js">
      </script>
    </div>
    <!-- Máscara para cobrir a tela -->
    <div id="mascara"></div> 
  </body>
</html>