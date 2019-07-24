<?php
	
	 //Função para Proteger o Código SQL
	function anti_sql_injection($recebe){
	   addslashes($recebe);
	  // Limpamos as tags HTML
	  $recebe = strip_tags($recebe);      
	  // Procuramos as palavras reservadas sql e deletamos
	  $sqlWords = "/([Ff][Rr][Oo][Mm]|[Ss][Ee][Ll][Ee][Cc][Tt]|[Cc][Oo][Uu][Nn][Tt]|[Tt][Rr][Uu][Nn][Cc][Aa][Tt][Ee]|[Ee][Xx][Pp][Ll][Aa][Ii][Nn]|[Ii][Nn][Ss][Ee][Rr][Tt]|[Dd][Ee][Ll][Ee][Tt][Ee]|[Ww][Hh][Ee][Rr][Ee]|[Uu][Pp][Dd][Aa][Tt][Ee]|[Ee][Mm][Pp][Tt][Yy]|[Dd][Rr][Oo][Pp] [Tt][Aa][Bb][Ll][Ee]|[Ll][Ii][Mm][Ii][Tt]|[Ss][Hh][Oo][Ww] [Tt][Aa][Bb][Ll][Ee][Ss]|[Oo][Rr]|[Oo][Rr][Dd][Ee][Rr] [Bb][Yy]|#|\*|--|\\\)/";
	  $recebe = preg_replace($sqlWords,'', $recebe);  
		return $recebe;
	 }
	 
	 function inserir($link,$tabela,$campos){
	   return mysqli_query($link,"insert into $tabela VALUES (0,$campos)");	 
	 }
	 
	 
	 function formatarData($data){
      $rData = implode("-", array_reverse(explode("/", trim($data))));
      return $rData;
   }
   
   //Função que faz o Upload da imagem e altera o Tamanho
function upload($imagem,$diretorio,$link,$tabela,$largura,$altura){
	try{
	//Gero o Nome da Imagem
	$consulta = mysqli_query($link,"select coalesce(max(id),1) as cod from ". $tabela) or die ("erro no SQL");
    $gerar = mysqli_fetch_array($consulta);
    $nome_novaimagem = $gerar["cod"] + 1;
	$caminho_arquivo = $diretorio . $nome_novaimagem . ".png";
   
    //Verifico o Tipo Da Imagem de Entrada
	$formato = $imagem["type"];
	if($formato == "image/jpeg"){
	  $img = imagecreatefromjpeg($imagem["tmp_name"]);
	}elseif($formato == "image/pjpeg"){
	  $img = imagecreatefromjpeg($imagem["tmp_name"]);
    }elseif($formato == "image/jpg"){
	  $img = imagecreatefrompng($imagem["tmp_name"]);
	}elseif($formato == "image/x-png"){
	  $img = imagecreatefrompng($imagem["tmp_name"]);
	}elseif($formato == "image/png"){
	  $img = imagecreatefrompng($imagem["tmp_name"]);
	}elseif($formato == "image/gif"){
	  $img = imagecreatefromgif($imagem["tmp_name"]);
	}else{
		$erro = "Formato da Imagem Não Aceito!";
	}

     list($width, $height) = getimagesize($imagem["tmp_name"]);
     $newwidth = $largura;  //490
	 $newheight = $altura;  //230

	 $novaimagem = imagecreatetruecolor($newwidth, $newheight);
     imagecopyresampled($novaimagem,$img,0,0,0,0,$newwidth, $newheight,$width,$height);
	$fundoPreto = imagecolorallocate($novaimagem, 255,255,255);         //pinta o fundo de Branco
	//$transparencia = imagecolortransparent ($novaimagem, $fundoPreto); //deixa transparente
    imagepng($novaimagem,$caminho_arquivo);
	imagedestroy($img);
	imagedestroy($novaimagem);	
	//return $caminho_arquivo;
	$caminho_arquivoBD =  $nome_novaimagem . '.png';
     return $caminho_arquivoBD; 
	}catch (Exception $e){
	   return "ERRO";
    }
}

function uploadFile($arquivo, $pasta, $tipos, $nome = null){
    if(isset($arquivo)){
        $infos = explode(".", $arquivo["name"]);
 
        if(!$nome){
            for($i = 0; $i < count($infos) - 1; $i++){
                @$nomeOriginal = $nomeOriginal . $infos[$i] . ".";
            }
        }
        else{
            $nomeOriginal = $nome . ".";
        }
 
        $tipoArquivo = $infos[count($infos) - 1];
 
        $tipoPermitido = false;
        foreach($tipos as $tipo){
            if(strtolower($tipoArquivo) == strtolower($tipo)){
                $tipoPermitido = true;
            }
        }
        if(!$tipoPermitido){
            $retorno["erro"] = "Tipo não permitido";
        }
        else{
            if(move_uploaded_file($arquivo['tmp_name'], $pasta . $nomeOriginal . $tipoArquivo)){
                $retorno["caminho"] = $pasta . $nomeOriginal . $tipoArquivo;
            }
            else{
                $retorno["erro"] = "Erro ao fazer upload";
            }
        }
    }
    else{
        $retorno["erro"] = "Arquivo nao setado";
    }
    return $retorno;
}

//Função para remover Acentuação
function RemoveAcentos($Msg){
 $a = array(
 "[ÂÀÁÄÃ]"=>"A",
 "[âãàáä]"=>"a",
 "[ÊÈÉË]"=>"E",
 "[êèéë]"=>"e",
 "[ÎÍÌÏ]"=>"I",
 "[îíìï]"=>"i",
 "[ÔÕÒÓÖ]"=>"O",
 "[ôõòóö]"=>"o",
 "[ÛÙÚÜ]"=>"U",
 "[ûúùü]"=>"u",
 "ç"=>"c",
 "Ç"=>"C");
 return preg_replace(array_keys($a), array_values($a), $Msg);
 }
	 
?>