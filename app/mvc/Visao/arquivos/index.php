<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="<?= URL_CSS . 'reset.css' ?>">
    <link rel="stylesheet" href="<?= URL_CSS . 'profile.css' ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
</head>

<style>

</style>

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
        <section class="upload">
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
            <h3>Compartilhe um arquivo com a comunidade</h3>
            <form action="<?= URL_RAIZ . 'arquivos' ?>" method="POST" enctype="multipart/form-data">
                <textarea name="descricao" id="description" cols="60" rows="5" placeholder="Adicione uma descrição para seu arquivo...."></textarea>

                <label for="file"><img class="icon-file" src="<?= URL_IMG . '/icons/file.png' ?>" alt="file"> Escolha um arquivo</label>
                <input type="file" name="arquivo" id="file" class="inputfile" />
                <button>Enviar</button>

            </form>
        </section>

        <div class="feed">
            <span>Feed</span>

            <section class="filter">
                <form action="">

                    <div>
                    Selecione o campo para ordenar: <br>
                         data:<input type="radio" id="age1" name="ordenacao" value="criado_em" class='checkbox'>
                         ordem alfabética: <input type="radio" class="checkbox" name="ordenacao" value="nome" class="checkbox">
        
                    </div>
                    Filtrar por descrição: <input type="text" name="filtro" class="input-filter" <?= $filtro ? 'value="'. $filtro. '"' : '' ?>>
                    <button class="search"><img src="<?= URL_IMG . 'icons/search-icon.png' ?>" alt="search"></button>
                </form>
            </section>

            <section class="pagination">
                <ol>
                    <span>Página: </span>
                    <?php for($i=$ultimaPagina; $i >= 1; $i--) : ?>
                        <li><a href="<?= URL_RAIZ . 'arquivos?p=' . ($ultimaPagina - ($i - 1)) ?>"><?= $ultimaPagina - ($i - 1) ?></a></li>
                    <?php endfor ?>
                </ol>
            </section>
            <?php foreach($arquivos as $arquivo) : ?>
                <section class="post-file">
                    <figure>
                        <img class="file-posted" src="<?= URL_IMG . 'icons/file.png' ?>" alt="file-posted">
                        <figcaption>
                            <span class="title">Arquivo: </span><?= $arquivo->getNomeOriginal() ?>
                            <h4>Descrição</h4>
                            <p><?= $arquivo->getDescricao() ?></p>
                            <a href="<?= URL_PUBLICO . 'uploads/' . $arquivo->getNome() ?>" class="download" download>Download</a>
                        </figcaption>
                    </figure>

                    <div class="comments">
                        <span class="title">Outros comentários:</span>

                        <?php foreach($arquivo->getComentarios() as $comentario) : ?>
                            <section class="comment">
                                <span><?= $comentario->getUsuario()->getNome() ?></span>
                                <p><?= $comentario->getTexto() ?></p>
                                <?php if($comentario->getUserId() == $usuario->getId()) : ?>
                                    <div class="options">
                                        <a href="<?= URL_RAIZ . 'comentarios/' . $arquivo->getId() . '/editar/' . $comentario->getId() ?>" class="update">Editar</a>
                                        <!-- <a href="profile.html" class="delete">Apagar</a> -->
                                        <form action="<?= URL_RAIZ . 'comentarios/' . $comentario->getId() ?>" method="POST" class="form-delete">
                                            <input type="hidden" name="_metodo" value="DELETE">
                                            <a href="" class="delete"  onclick="event.preventDefault(); this.parentNode.submit()">Apagar</a>
                                        </form>
                                    </div>
                                <?php endif ?>
                            </section>
                        <?php endforeach ?>
                        <a href="<?= URL_RAIZ . 'comentarios/' . $arquivo->getId() . '/criar'?>" class="btn-comment">
                            Comentar
                        </a>
                    </div>
                </section>
            <?php endforeach ?>
          
        </div>
    </main>


    <script src="<?= URL_JS . 'script.js' ?>"></script>
</body>

</html>