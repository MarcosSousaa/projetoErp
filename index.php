<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Grenky Sistemas</title>
    <link href="includes/estiloindex.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="includes/jquery.js"></script>
    <script type="text/javascript" src="includes/meiomask.js" charset="utf-8"></script>
    <script type="text/javascript" src="emitente/acoes.js"></script>
    <script type="text/javascript" src="includes/jslogin.js"></script>
    <script type="text/javascript">      
      $(document).ready(function(){		  
  		  $("a[rel=modal]").click( function(ev){
          ev.preventDefault();
          var id = $(this).attr("href");
          var alturaTela = $(window).height();
          var larguraTela = $(window).width();  
          //colocando o fundo preto
          $('#mascara').css({'width':larguraTela,'height':alturaTela});
          $('#mascara').fadeIn(1000); 
          $('#mascara').fadeTo("slow",0.8);
          var left = ($(window).width() /2) - ( $(id).width() / 2 );
          var top = ($(window).height() / 2) - ( $(id).height() / 2 );
          $(id).css({'top':top,'left':left});
          $(id).show();   
        });
        // $("#mascara").click( function(){
        //     $(this).hide();
        //     $(".window").hide();
        // });
        $('.fechar').click(function(ev){
          ev.preventDefault();
          $("#mascara").hide();
          $(".window").hide();
        });
        $("select[name=estado]").change(function(){
          $("select[name=cidade]").html('<option value="0">Carregando...</option>');    
          $.post("includes/cidades.php", {estado:$(this).val()},
            function(valor){
             $("select[name=cidade]").html(valor);
            }
          )
              
        })
      })      
    </script>
    <script type="text/javascript">
      (function($){
        $(function(){
			   $('input:text').setMask();
		    });
      })(jQuery);
    </script>
  </head>
  <body>
    <div id="Principal" style="width:900px;height:300px;margin:auto">
      <div id="Login" style="width:300px;height:200px; margin-top:100px;float:right">
        <form method="post" action="" name="Logar" id="Logar">
          <table width="100%" height="129" style="border:dashed 2px #333">
            <tr>
              <td colspan="2">Fa&ccedil;a Seu login:</td>
            </tr>
            <tr>
              <td height="43" align="left" valign="top">Email:</td>
              <td align="left" valign="top">
                <input name="email" type="text" id="email" size="30" />
                <br />ex: seunome@seuprovedor.com.br 
              </td>
            </tr>
            <tr>
              <td>Senha:</td>
              <td>
                <input type="password" name="usersenha" id="usersenha" /> &nbsp;
                <input type="submit" name="entrar" id="entrar" value="Enviar" />
              </td>
            </tr>
            <tr>
              <td colspan="2" style="text-align: right">
                <div id="status" style="float:left">
                  
                </div>
              </td>
            </tr>
          </table>
        </form>
        <br />
        <table width="100%" height="60" style="border:dashed 2px #333">
          <tr>
            <td colspan="2">Ainda n&atilde;o &eacute; Cadastrado? 
              <a href="#janela1" rel="modal">Cadastre-se!</a>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <div style="width:100%;background-color:#F60;height:30px;margin-top:70px;text-align:center;padding-top:15px;padding-bottom:15px;">
      <a href="?acao=Inicio" class="linkmenu">Como Emitir uma NFe</a> |  
      <a href="?acao=Planos" class="linkmenu">Confira nossos Planos</a>
    </div>
    <div id="Conteudo" style="text-align:center">
      <?php 
        if (isset($_GET["acao"])){
          switch($_GET["acao"]){
            case 'Planos' : 
              include_once 'planos.php'; 
            break;	
            default : 
              echo ' 
                <h2>Como Emitir Uma NFe no EmissorNfe.net</h2>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/88SfLaqe4G8" frameborder="0" allowfullscreen>
                </iframe>'; 
            break;	
	        }
        }else{
	       echo ' 
          <h2>Como Emitir Uma NFe no EmissorNfe.net</h2>
          <iframe width="560" height="315" src="https://www.youtube.com/embed/88SfLaqe4G8" frameborder="0" allowfullscreen>
          </iframe>';  
        }
      ?>
    </div>
    <div class="window" id="janela1">
      <a href="#" class="fechar">X Fechar</a>
      <div style="text-align:center">
        <h1>Preencha os dados abaixo para criar sua conta</h1>
      </div> 
      <form method="post" action="" id="GravarEmitente" name="GravarEmitente">
        <div id="Formulario">
          <label></label>
          <table border="0">
            <tr>
              <td colspan="2">
                <p class="caption" id="lbl-nome">CNPJ</p>
                <input type="text" name="cnpj" id="cnpj" alt="cnpj" />
              </td>
              <td>
                <p class="caption" id="lbl-nome">Regime Tributário</p>
                <select name="regime" id="regime" class="CadCli">
                  <option value="0" selected="selected">Simples Nacional</option>
                </select>
              </td>
            </tr>
            <tr>
              <td colspan="3">
                <p class="caption" id="lbl-nome">Nome/Razão Social</p> 
                <input type="text" name="nome" id="nome" size="56"/>
              </td>
            </tr>
            <tr>
              <td>
                <p class="caption" id="lbl-nome">CEP</p>
                <input type="text" name="cep" id="cep" size="9" alt="cep" /> 
              </td>
              <td>
                <p class="caption" id="lbl-nome">Endereço</p>
                <input type="text" name="endereco" id="endereco" size="30" /> 
              </td>
              <td>
                <p class="caption" id="lbl-nome">Número</p>
                <input type="text" name="numero" id="numero" size="6" />
              </td>
            </tr>
            <tr>
              <td colspan="2">
                  <p class="caption" id="lbl-nome">Bairro</p>
                  <input type="text" name="bairro" id="bairro" size="45" />
              </td> 
              <td>
                <p class="caption" id="lbl-nome">Complemento</p>
                <input type="text" name="complemento" id="complemento" size="20" />
              </td>
            </tr>
            <tr>
              <td>
                <p class="caption" id="lbl-nome">Estado</p>
                <select name="estado" id="estado" class="CadCli">
                 <option value="0">Escolha um Estado</option>
                 <?php
  			           include_once "includes/conexao.php";
  					         $estados = mysqli_query($conexao,"select distinct codigo_estado,  sigla_estado from cidades order by sigla_estado ASC");
  					         while ($lista_estados = mysqli_fetch_array($estados))
                     {
  					           echo "<option value=\"".$lista_estados["codigo_estado"]."\">".$lista_estados["sigla_estado"]."</option>";							   
  			             } 
  						  
  						    ?>
                </select> 
              </td>
              <td colspan="1">  
                <p class="caption" id="lbl-nome">Cidade</p>
                <select name="cidade" id="cidade" class="CadCli">
                  <option value="0" disabled="disabled">
                    Escolha um Estado Primeiro
                  </option>
                </select>
              </td>          
              <td colspan="2">  
                <p class="caption" id="lbl-nome">Selecione um Plano</p>
                <select name="plano" id="plano" class="CadCli">
                  <option value="0" selected="selected">
                    Gratuito (Até 5 notas por mês)
                  </option>
                  <option value="1">
                    Light R$20,00 mensais (Até 20 notas por mês)
                  </option>
                  <option value="2">
                    Profissional R$40,00  (Até 50 notas por mês)
                  </option>
                  <option value="3">
                    FULL R$60,00 (Emissão de notas ilimitadas)
                  </option>
                </select>
              </td>          
            </tr>
          </table> 
          <h1>Dados de Login</h1>
          <table>
            <tr>
              <td>
                <p class="caption" id="lbl-nome">Email</p>
                <input type="text" name="email" id="email" size="40" />
              </td>
              <td>
                <p class="caption" id="lbl-nome">Senha</p>
                <input type="password" name="senha" id="senha" size="10" />
              </td>
              <td>
                <p class="caption" id="lbl-nome">Confirmar Senha</p>
                <input type="password" name="senha2" id="senha2" size="10" />
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <p class="caption" id="lbl-nome">
                  <input name="termo" id="termo" type="checkbox" value="S" />
                  Aceitar os 
                  <a href="termos.php" target="_blank">Termos de uso</a>
                </p> 
                <font style="font-size:12px; color:#D90509;">
                  <strong>
                    O EmissorNFe.net atende apenas empresas optantes pelos regimes Simples Nacional e MEI
                  </strong>
                </font>
              </td>
              <td> 
                <input type="submit" value="Gravar" id="BtnGravarEmitente" name="BtnGravarEmitente" />
              </td>
            </tr>
          </table>
        </div>
      </form>      
    </div>     
    <!-- mascara para cobrir o site -->  
    <div id="mascara"></div>
  </body>
</html>