<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <link rel="stylesheet" href="<?= URL_CSS . 'reset.css'?>">
    <link rel="stylesheet" href="<?= URL_CSS . 'comment.css' ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
  
</head>

<body>
    <header>
    <nav class="navbar">
            <a href="" class="logo">
                <img src="<?= URL_IMG . 'compartilhaBytes.png' ?>" alt="logo">
            </a>
            <div class="message-user">
                Olá, <?= $usuario->getNome() ?>
            </div>
            <div class="hamburguer"></div>

            <ul class="menu">
                <li><a href="<?= URL_RAIZ . 'arquivos' ?>"><img src="<?= URL_IMG . 'icons/home.svg' ?>"> Home</a></li>
                <li><a href="<?= URL_RAIZ . 'relatorios' ?>"><img src="<?= URL_IMG . '/icons/report-icon.png' ?>"> Relatórios</a></li>
                <li>
                    <form action="<?= URL_RAIZ . 'login' ?>" method="post" class="inline">
                        <input type="hidden" name="_metodo" value="DELETE">
                        <a href="" class="btn btn-default" onclick="event.preventDefault(); this.parentNode.submit()">
                            <img src="<?= URL_IMG . '/icons/logout.svg' ?>">Sair
                        </a>
                    </form>
                <li>
            </ul>
        </nav>
    </header>
    <main>
       <div class="container">
           <div class="file-info">
            <span>Arquivo:</span> <?= $arquivo->getNomeOriginal() ?>
            <h4>Descrição:</h4>
            <p><?= $arquivo->getDescricao() ?></p>
           </div>
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
           <form action="<?= URL_RAIZ . 'comentarios' ?>" method="POST">
               <label for="comment" class="label-comment">Comentário:</label>
               <textarea name="comentario" id="description" cols="60" rows="5" placeholder="Digite seu comentário...."></textarea>
               <input type="hidden" name="arquivo_id" value="<?= $arquivo->getId() ?>">
               <button>Enviar</button>
           </form>
       </div>
    </main>

    
    <script src="<?= URL_JS . 'script.js' ?>"></script>
</body>
</html>