<?php

require __DIR__.'/vendor/autoload.php';

use \App\File\Upload;

if(isset($_FILES['arquivo'])){
    // INSTANCIA DE UPLOAD
    $obUpload = new Upload($_FILES['arquivo']);
    
    // MOVE OS ARQUIVOS DE UPLOAD
    // PARÂMETRO '$overwrite' DEFINI SE DEVE OU NÃO SOBRESCREVER O ARQUIVO SE TIVER O MESMO NOME E TIPO
    $sucesso = $obUpload->upload(__DIR__.'/files', false);
    if(!$sucesso['status'])
        die($sucesso['mensagem']);
        
    echo('Arquivo <strong>'.$obUpload->getBasename().'</strong> enviado com sucesso!');
    exit;
}

include __DIR__.'/includes/formulario.php';