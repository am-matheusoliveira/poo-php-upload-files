<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Upload de arquivos com PHP e POO</title>
    <link rel="stylesheet" href="/poo-php-upload-files/assets/css/style.css">
</head>
<body>
    <main class="screen" role="main">
        <div class="backdrop" aria-hidden="true">
            <header class="screen__header" aria-labelledby="title">
                <h1 id="title" class="title">Upload de arquivos com PHP e POO</h1>
            </header>
            
            <section class="panel" aria-labelledby="panel-heading">
                <h2 id="panel-heading" class="panel__heading">Múltiplos arquivos ?</h2>

                <p class="panel__title__field">
                    <a class="btn" href="multi.php" rel="noopener">Múltiplos arquivos</a>
                </p>

                <form id="uploadForm" method="post" enctype="multipart/form-data" novalidate>
                    <div class="field">
                        <label class="label" for="arquivo">Clique no botão abaixo para selecionar o arquivo</label>
                        <input id="arquivo" type="file" name="arquivo"/>
                    </div>
                </form>
            </section>

            <!-- Botão fora do form, ainda envia via atributo "form" -->
            <button class="cta-submit" type="submit" form="uploadForm">Enviar</button>
        </div>
    </main>
</body>
</html>
