<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Upload de arquivos com PHP e POO (MULTI)</title>
    <link rel="stylesheet" href="/poo-php-upload-files/assets/css/style.css">
</head>
<body>
    <main class="screen" role="main">
        <div class="backdrop" aria-hidden="true">
            <header class="screen__header" aria-labelledby="title">
                <h1 id="title" class="title">Upload de arquivos com PHP e POO (MULTI)</h1>
            </header>
            
            <section class="panel" aria-labelledby="panel-heading">
                <h2 id="panel-heading" class="panel__heading">Unico arquivo ?</h2>
                
                <p class="panel__title__field">
                    <a class="btn" href="index.php" rel="noopener">Unico arquivo</a>
                </p>
                
                <form id="uploadForm" method="post" enctype="multipart/form-data" novalidate>
                    <div class="field">
                        <label class="label" for="arquivo">Clique no botão abaixo para selecionar os arquivos</label>
                        <input id="arquivo" type="file" name="arquivo[]" multiple/>
                    </div>
                </form>
            </section>

            <!-- Botão fora do form, ainda envia via atributo "form" -->
            <button class="cta-submit" type="submit" form="uploadForm">Enviar</button>
        </div>
    </main>
</body>
</html>
