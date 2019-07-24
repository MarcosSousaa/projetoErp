<?php
$diretorio = getcwd().'/pasta_teste/';

// Instancia a Classe Zip
$zip = new ZipArchive();
// Cria o Arquivo Zip, caso não consiga exibe mensagem de erro e finaliza script
if($zip->open('nome_arquivo_zip.zip', ZIPARCHIVE::CREATE) == TRUE)
{
// Insere os arquivos que devem conter no arquivo zip
$zip->addFile($diretorio.'arquivo1.txt','arquivo1.txt');
$zip->addFile($diretorio.'arquivo2.txt','arquivo2.txt');

echo 'Arquivo criado com sucesso.';
}
else
{
exit('O Arquivo não pode ser criado.');
}

// Fecha arquivo Zip aberto
$zip->close();
?>