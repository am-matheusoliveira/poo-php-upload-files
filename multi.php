<?php

require __DIR__.'/vendor/autoload.php';

use \App\File\Upload;

if(isset($_FILES['arquivo'])){    
    // CRIA UM ARRAY DE MÚLTIPLOS ARQUIVOS
    $uploads = Upload::createMultiUpload($_FILES['arquivo']);
    
    foreach($uploads as $obUpload){
        // MOVE OS ARQUIVOS DE UPLOAD
        // PARÂMETRO '$overwrite' DEFINI SE DEVE OU NÃO SOBRESCREVER O ARQUIVO SE TIVER O MESMO NOME E TIPO
        $sucesso = $obUpload->upload(__DIR__.'/files', false);
        if(!$sucesso['status']){
            echo($sucesso['mensagem'] . '<br>');
            continue;
        }
        
        echo('Arquivo <strong>'.$obUpload->getBasename().'</strong> enviado com sucesso!<br>');
    }
    
    exit;
}

include __DIR__.'/includes/formulario-multi.php';