<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="description" content="a descrição do seu site em no máximo 90 caracteres">
        <meta name="keywords" content="escreva palavras-chaves curtas, máximo 150 caracteres">
        <title>Título do Documento</title>
    </head>
    <body>
        <h1>Sites Cadastrados</h1>
        <dl>
        <?php foreach ($sites as $site): ?>
        <dt><?php echo $site->nome; ?></dt>
        <dd>
            Acessível em: /<?php echo $site->slug; ?><br>
            Cliente: <?php echo $site->getCliente()->nome; ?>
        </dd>
        <?php endforeach; ?>
        </dl>
    </body>
</html>