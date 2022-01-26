<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APLICACAO_NOME ?></title>
    <link rel="stylesheet" href="<?= URL_CSS . 'register.css' ?>">
</head>

<body>

    <form action="<?= URL_RAIZ . 'usuarios' ?>" method="POST">

        <img src="<?= URL_IMG . 'compartilhaBytes.png' ?> ">


        <?php if ($mensagem && !is_array($mensagem)) : ?>
            <span class="alert-success"> <?= $mensagem ?></span>
        <?php endif ?>

        <?php if ($mensagem && is_array($mensagem)) : ?>
            <span class="alert-error">
                <?php foreach ($mensagem as $key => $erro) : ?>
                    <?= "$key $erro" ?> <br>
                <?php endforeach ?>
            </span>
        <?php endif ?>

        <h1>Cadastro</h1>

        <input type="nome" name="nome" placeholder="Nome">
        <input type="email" name="email" placeholder="Email">

        <input type="password" name="senha" id="" placeholder="Senha">
        <small>
            <a href="<?= URL_RAIZ  ?>">Voltar para o login</a>
        </small>
        <button>Registrar</button>
    </form>
</body>

</html>