<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<link rel="stylesheet" href="includes/datatable/estilo/table_jui.css" />
<link rel="stylesheet" href="includes/datatable/estilo/jquery-ui-1.8.4.custom.css" />
<style>
  .progress { position:relative; width:348px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
  .bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
  .percent { position:absolute; display:inline-block; top:3px; left:48%; }
  #upload{
	margin:0px 10px; 
	padding:2px;
	font-weight:bold; font-size:12px;
	font-family:Arial, Helvetica, sans-serif;
	text-align:center;
	background:#f2f2f2;
	color:#3366cc;
	border:1px solid #ccc;
	width:150px;
	cursor:pointer !important;
	-moz-border-radius:5px; -webkit-border-radius:5px;
}
.darkbg{
	background:#ddd !important;
}
#status{
	font-family:Arial; padding:5px;
}
ul#files{ list-style:none; padding:0; margin:0; }
ul#files li{ padding:10px; margin-bottom:2px; width:200px; float:left; margin-right:10px;}
ul#files li img{ max-width:180px; max-height:150px; }
.success{ background:#99f099; border:1px solid #339933; }
.error{ background:#f0c6c3; border:1px solid #cc6622; }
  
</style>
 <script src="includes/jquery.js"></script>
 <script src="includes/jquery-ui.js"></script>
 <script type="text/javascript" src="includes/meiomask.js"></script>
 <script src="includes/ajaxupload.js"></script>
<script> 
    $(document).ready(function() {	
	jQuery.noConflict();
jQuery(function($){
   $("#data").mask("99/99/9999");
   $("#telefone").mask("(099) 9999-9999");
   $("#cep").mask("99999-999");   
   $("#placa").mask("aaa - 9999");
   $("#cnpj").mask("99.999.999/9999-99"); 
   }); 
		 
		 
		 
		  $("select[name=estado]").change(function(){
            $("select[name=cidade]").html('<option value="0">Carregando...</option>');
            
            $.post("includes/cidades.php", 
                  {estado:$(this).val()},
                  function(valor){
                     $("select[name=cidade]").html(valor);
                  }
                  )
            
         })	
		 
		 
		 //Salvar Novo Emitente
		 
$('#BtnGravarEmitente').on('click', function() {
		$('#AtualizarEmitente').submit();
		$.post('emitente/alterar.php', $('#AtualizarEmitente').serialize(), function(resposta){
	
		 if (resposta == 0){
		  $("#sucesso").dialog();
		 }else{
			 alert(resposta);
			//  alert("Ocorreu algum erro durante a Atualização!"); 
		 }
		//$("#Formulario").html(resposta);
		//$('#GravarEmitente').prepend(resposta).find('label').fadeOut(3000, function(){$(this).remove();});
		//$('#GravarEmitente input[type=text]').removeClass('loading');
		//$('form')[0].reset();		
	})

	return false;
}) 
	
	$("#EfetuarPagamento").on('click', function(e) {
	   e.preventDefault();	
       $.post('pagseguro.php','',function(data){
        $('#code').val(data);
        $('#pagarMensalidade').submit();
      })
    })	
		   
		 
	 
	}); 		
	
</script>

<script type="text/javascript" >
	$(function(){
		var btnUpload=$('#upload');
		var status=$('#status');
		new AjaxUpload(btnUpload, {
			// Arquivo que fará o upload
			action: 'emitente/upload.php',
			//Nome da caixa de entrada do arquivo
			name: 'arquivo',
			onSubmit: function(file, ext){
				 if (! (ext && /^(pfx)$/.test(ext))){ 
                    // verificar a extensão de arquivo válido
					status.text('Somente arquivos de certificados .Pfx são permitidas');
					return false;
				}
				status.text('Enviando...');
			},
			onComplete: function(file, response){
				//Limpamos o status
				status.text('');
				//Adicionar arquivo carregado na lista
				if(response==="success"){
					$('<li></li>').appendTo('#files').html(file).addClass('success');
				} else{
					$('<li></li>').appendTo('#files').text(file).addClass('error');
				}
			}
		});
		
	});
</script>



	
<form method="post" action="" id="AtualizarEmitente" name="AtualizarEmitente">
    <div id="Formulario">
    <label></label>
     <table border="0">
        <tr><td>
          <p class="caption" id="lbl-nome">CNPJ</p>
          <input type="text" name="cnpj" id="cnpj" value="<?php echo $_SESSION["emitente"]["cnpj"]; ?>" /></td>
          <td>
          <p class="caption" id="lbl-nome">IE</p>
          <input type="text" name="ie" id="ie" value="<?php echo $_SESSION["emitente"]["ie"]; ?>" /></td>
          <td>
          <p class="caption" id="lbl-nome">IM</p>
          <input type="text" name="im" id="im" alt="im" value="<?php echo $_SESSION["emitente"]["im"]; ?>" /></td>
          <td colspan="2">
          <p class="caption" id="lbl-nome">CNAE</p>
          <input type="text" name="cnae" id="cnae" alt="cnae" value="<?php echo $_SESSION["emitente"]["cnae"]; ?>" /></td>
          </tr>
        <tr>
        <td colspan="2">
          <p class="caption" id="lbl-nome">Razão Social</p> 
          <input type="text" name="nome" id="nome" value="<?php echo $_SESSION["emitente"]["nome"]; ?>" size="46"/>
        </td>
        <td colspan="4">
          <p class="caption" id="lbl-nome">Nome Fantasia</p> 
          <input type="text" name="fantasia" id="fantasia" value="<?php echo $_SESSION["emitente"]["fantasia"]; ?>" size="46"/>
        </td>        
        </tr>
        <tr>
           <td>
            <p class="caption" id="lbl-nome">CEP</p>
            <input type="text" name="cep" id="cep" size="18" alt="cep" value="<?php echo $_SESSION["emitente"]["cep"]; ?>" /> 
           </td>
           <td colspan="2">
            <p class="caption" id="lbl-nome">Endereço</p>
            <input type="text" name="endereco" size="50" value="<?php echo $_SESSION["emitente"]["endereco"]; ?>" /> 
           </td>
           <td colspan="3">
            <p class="caption" id="lbl-nome">Número</p>
            <input type="text" name="numero" size="6" value="<?php echo $_SESSION["emitente"]["numero"]; ?>" />
            </td></tr>
          <tr><td colspan="2">
                <p class="caption" id="lbl-nome">Bairro</p> <input type="text" name="bairro" size="45" value="<?php echo $_SESSION["emitente"]["bairro"]; ?>" />
              </td> 
              <td>
                <p class="caption" id="lbl-nome">Complemento</p> <input type="text" name="complemento" size="20" value="<?php echo $_SESSION["emitente"]["complemento"]; ?>" />               
          </td>
          <td colspan="3">
          <p class="caption" id="lbl-nome">Telefone</p> 
          <input type="text" name="telefone" id="telefone" size="10" value="<?php echo $_SESSION["emitente"]["telefone"]; ?>"/>
        </td>
          </tr>
          <tr>
          
          <td> <p class="caption" id="lbl-nome">PAÍS</p>
             <select name="pais" id="pais" class="CadCli" disabled="disabled">
              <option value="0">BRASIL</option>
             </select>
            </td>
          
          <td>
    
          <p class="caption" id="lbl-nome">Estado</p>
            <select name="estado" id="estado" class="CadCli">                
                           <?php
						   $estados = mysqli_query($conexao,"select distinct codigo_estado,  sigla_estado from cidades order by sigla_estado ASC");
						   while ($lista_estados = mysqli_fetch_array($estados)){
							   if ($lista_estados["codigo_estado"] == $_SESSION["emitente"]["codigo_estado"]){
								echo '<option value="'.$lista_estados["codigo_estado"].'" selected="selected">'.$lista_estados["sigla_estado"].'</option>';   
							   }else{
							   echo "<option value=\"".$lista_estados["codigo_estado"]."\">".$lista_estados["sigla_estado"]."</option>";
							   }
							   
						   } 
						   ?>
                           </select> </td>
            <td colspan="2">  
              <p class="caption" id="lbl-nome">Cidade</p>
              <select name="cidade" id="cidade" class="CadCli">
                               <?php
							   $cidades = mysqli_query($conexao,"select codigo_cidade, nome_cidade from cidades where codigo_estado = '".$_SESSION["emitente"]["codigo_estado"]."' order by nome_cidade");
						   while ($lista_cidades = mysqli_fetch_array($cidades)){
							   if ($lista_cidades["codigo_cidade"] == $_SESSION["emitente"]["codigo_cidade"]){
								echo '<option value="'.$lista_cidades["codigo_cidade"].'" selected="selected">'.$lista_cidades["nome_cidade"].'</option>';   
							   }else{
					 echo "<option value=\"".$lista_cidades["codigo_cidade"]."\">".$lista_cidades["nome_cidade"]."</option>";
							   }
						   } 
							   ?>
                               
                             </select>
          </td>
          <td valign="bottom"><input type="submit" value="Gravar" id="BtnGravarEmitente" name="BtnGravarEmitente" class="but" /></td>
          </tr>
       </table> 
   </form>
      
      
      
      
      
      <h2>Dados de Login</h2>
        <table>
          <tr><td>
      <p class="caption" id="lbl-nome">Email</p>
       <input type="text" name="email" size="40" value="<?php echo $_SESSION["emitente"]["email"]; ?>" disabled="disabled" /></td>
       <td><p class="caption" id="lbl-nome">Senha</p>
       <input type="text" name="senha" size="10" /></td>
       <td valign="bottom">
       <input type="button" value="Alterar Senha" name="btnAlteraSenha" id="btnAlteraSenha" class="but" /></td>
       <td valign="bottom" align="center">
         <input type="button" value="Pagar Mensalidade" class="but" id="EfetuarPagamento" >          
       </td>
       </tr></table>
       <form id="pagarMensalidade" action="https://pagseguro.uol.com.br/checkout/v2/payment.html" method="post" onsubmit="PagSeguroLightbox(this); return false;">
           <input type="hidden" name="code" id="code" value="" />
           </form>
<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
       
       
       <h2>Certificado Digital</h2>
  
       <div id="mainbody" >
		<div id="upload" ><span>Enviar Certificado<span></div><span id="status" ></span>
		
		<ul id="files" >
        
             <?php
       $types = array( 'pfx' );
if ( $handle = opendir("nfephp/certs/$id_emitente") ) {
    while ( $entry = readdir( $handle ) ) {
        $ext = strtolower( pathinfo( $entry, PATHINFO_EXTENSION) );
        if( in_array( $ext, $types ) ) echo "<li class=\"success\">".$entry."</li>";
    }
    closedir($handle);
}   
?>
        </ul>
</div>


       
       
    </div>
  
