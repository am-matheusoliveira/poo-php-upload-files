<?php

require __DIR__.'/vendor/autoload.php';

use \App\File\Upload;

if(isset($_FILES['arquivo'])){
    
    $uploads = Upload::createMultiUpload($_FILES['arquivo']);

    foreach($uploads as $obUpload){

        // ALTERA O NOME DO ARQUIVO - NOME FIXO
        // $obUpload->setName('novo-arquivo-com-nome-alterado');
        
        // GERA UM NOME ALEATÓRIO
        $obUpload->generateNewName();

        // MOVE OS ARQUIVOS DE UPLOAD
        // PARÂMETRO '$overwrite' DEFINI SE DEVE OU NÃO SOBRESCREVER O ARQUIVO SE TIVER O MESMO NOME E TIPO
        $sucesso = $obUpload->upload(__DIR__.'/files', false);
        if($sucesso){
            echo('Arquivo <strong>'.$obUpload->getBasename().'</strong>enviado com sucesso!<br>');
            continue;
        }

        echo('Problemas ao enviar o arquivo <br>');
    }

    exit;
}

include __DIR__.'/includes/formulario-multi.php';