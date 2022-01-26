<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <link rel="stylesheet" href="<?= URL_CSS . 'reset.css'?>">
    <!-- <link rel="stylesheet" href="./styles/profile.css"> -->
    <link rel="stylesheet" href="<?= URL_CSS . 'report.css' ?>">
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
                <li><a href="./report.html"><img src="<?= URL_IMG . '/icons/report-icon.png' ?>"> Relatórios</a></li>
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
       <h2>Relatório de arquivos enviados</h2>


       <section class="filter">
        <form action="<?= URL_RAIZ . 'relatorios' ?>" method='GET'>
            
            Data inicial:<input type="date" name="dataInicial"> 
            Data final:<input type="date" name="dataFinal"> 

            <!-- Ordenar por ordem alfabética: <input type="checkbox" class="checkbox"> -->
            <button class="search"><img src="<?= URL_IMG . '/icons/search-icon.png' ?>" alt="search"></button>
        </form>
    </section>
       <table>
        <tr>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Data de upload</th>
        </tr>
        <?php foreach($registros as $registro) : ?>
           <tr>
               <td><?= $registro['nome_original'] ?></td>
               <td><?= $registro['descricao'] ?></td>
               <td><?= $registro['criado_em'] ?></td>
           </tr>
        <?php endforeach ?>
       </table>
    </main>

    
    <script src="<?= URL_JS . 'script.js' ?>"></script>
</body>
</html>