<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APLICACAO_NOME ?></title>
    <link rel="stylesheet" href="<?= URL_CSS . 'main.css' ?>">
    <link rel="stylesheet" href="<?= URL_CSS . 'register.css' ?>">
</head>

<body>
    <form action="<?= URL_RAIZ . 'login' ?>" method="POST">
        <img src="<?= URL_IMG . 'compartilhaBytes.png' ?> ">
        <?php if ($mensagem) : ?>
            <span class="alert-error"><?= $mensagem ?></span>
        <?php endif ?>

        <h1>Login</h1>

        <input type="email" name="email" placeholder="Email">

        <input type="password" name="senha" id="" placeholder="Senha">
        <small>
            <a href="<?= URL_RAIZ . 'usuarios/criar' ?>">Quero me cadastrar</a>
        </small>
        <button>Entrar</button>
    </form>
</body>

</html>