<!-- conexao do banco para acessar as informações dos servidores do popup//-->
<?php include("dbcannect.php");
$pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
if (!isset($_GET['pesquisar'])) {
    header("Location: index.php");
} else {
    $pesquisar_serv = $_GET['pesquisar'];
}

//pegar os dados da tabela
$consulta = "SELECT * FROM tb_funcionario WHERE nome LIKE '%$pesquisar_serv%'";
$consulta_result = mysqli_query($conn, $consulta);

//aqui é a qntidade toda
$resultado_total = mysqli_num_rows($consulta_result);

//aqui é a quantidade por pagina
$quantidade_pg = 6;

//continha basica pra saber qntidade de pagina
$num_pagina = ceil($resultado_total / $quantidade_pg);
$incio = ($quantidade_pg * $pagina) - $quantidade_pg;

//aqui é a busca dos dados que vai ser apresentado na pag
$consulta = "SELECT * FROM tb_funcionario WHERE nome LIKE '%$pesquisar_serv%' limit $incio, $quantidade_pg";
$con = $mysqli->query($consulta) or die($mysqli->error);
$resultado_total = mysqli_num_rows($consulta_result);
?>
<!-- acaba aqui a conexao -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-png" href="./imgs/icon.png" />
    <link rel="stylesheet" type="text/css" href="./css/index.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title> MONITORAÊ </title>
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function($) {
            $(".scroll").click(function(event) {
                event.preventDefault();
                $("html,body").animate({
                    scrollTop: $(this.hash).offset().top
                }, 800);
            });
        });
    </script>
</head>

<body>
    <!-- MENU -->
    <div class="header-2">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <a href="index.html"> <img src="./imgs/logo.png"></a>
        <div class="menu">
            <ul>
                <li>
                    <a href="PerfilPrefeito.html">Prefeito</a>
                </li>
                <li>
                    <a href="PerfilVereador.html">Vereadores</a>
                </li>
                <li>
                    <a href="#bg-2">Servidores</a>
                </li>
                <li>
                    <a class="scroll" href="#session2">Notícias</a>
                </li>
                <li>
                    <a class="scroll" href="#session3">Dashboard</a>
                </li>
                <li>
                    <a href="#bg"> Relatórios</a>
                </li>
            </ul>
        </div>
        <div class="busca">
            <input id="home" type="text" placeholder="O que você procura?                        " value="" tabindex="1" autocomplete="off">
        </div>
    </div>
    <!-- SESSION 1 - vereadores -->
    <div id="session1" class="vereadores-lista">

    </div>
    <!-- SESSION 2 - noticias -->
    <div id="session2" class="noticias-lista">

    </div>
    <!-- SESSION 3 - dashboard -->
    <div id="session3" class="dashboard-lista">

    </div>
    <!-- SESSION 4 - rodape -->
    <div id="session4" class="rodape-lista">
    </div>
    <!-- POP UP relatorios -->
    <div id="bg"> </div>
    <div class="box">
        <a href="" id="close"> x </a>
        <div class="tituloRel">
            RELATÓRIOS
        </div>
        <p>
            Pesquise de acordo com os filtros os relatórios que desejar!
        </p>
        <div class="tipo">
            <form method="post" action="">
                <select name="relatorio" style="width:150px;">
                    <option value="selecione">Selecione</option>
                    <option value="gastos">Gastos </option>
                    <option value="projetos">Projetos</option>
                </select>
            </form>
        </div>

        <div class="classi">
            <form method="post" action="">
                <select name="relatorio">
                    <option value="selecione">Selecione</option>
                    <option value="gastos">Geral </option>
                    <option value="projetos">Individual</option>
                </select>
            </form>
        </div>

        <div class="periodo">
            <input id="peri1" type="date" id="diaa" name="diaa">
            <label> á </label>
            <input id="peri2" type="date" id="diaa" name="diaa">
        </div>
        <div class="rela">
            <button id="rela">Gerar Relatório</button>
        </div>
        <div class="mensagem2"> Seu relatório será gerado em formato PDF! basta clicar no botão acima.
        </div>
    </div>
    <!-- POP UP servidores -->
    <div id="bg-2"> </div>
    <div class="box-2">
        <a href="" id="close-2"> x </a>
        <div class="tituloSer">
            Servidores
        </div>
        <!-- barra de pesquisa -->
        <div class="col-sm-6 col-md-6">
            <form class="form-inline" method="GET" action="pesquisar.php">
                <div class="form-group">
                    <label for="exampleInputName2">Pesquisar</label>
                    <input type="text" name="pesquisar" class="form-control" id="exampleInputName2" placeholder="Digitar...">
                </div>
                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </form>
        </div>
        <!-- fim da barra da pesquisa -->
        <!--tabela -->
        <div class="table-responsive">
            <table class="table">
                <!--cabeçalho da tabela -->
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Rendimentos</th>
                    </tr>
                </thead>
                <!-- fim do cabeçalho da tabela -->
                <tbody>
                    <!-- laço p/ prencher os dados da tabela -->
                    <?php while ($dado = mysqli_fetch_assoc($con)) { ?>
                        <tr>
                            <td><?php echo $dado['nome']; ?></td>
                            <td><?php echo $dado['cargo']; ?></td>
                            <td><?php echo $dado['rendimentos']; ?></td>
                        </tr>
                    <?php } ?>
                    <!-- fim do laço-->
                </tbody>
            </table>
        </div>
        <!--fim da tabela -->
        <!-- aqui começa a paginação -->
        <nav class="text-center">
            <ul class="pagination">
                <li>
                    <!-- pagina anterior -->
                    <?php
                    if ($anterior != 0) { ?>
                        <a href="index.php#session2?pagina=<?php echo $anterior; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    <?php } else { ?>
                        <span aria-hidden="true">&laquo;</span>
                    <?php }  ?>
                    <!-- pagina anterior -->
                </li>
                <!-- pagina-->
                <?php
                for ($i = 1; $i < $num_pagina + 1; $i++) { ?>
                    <li><a href="index.php#session2?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php } ?>
                <!-- fim pagina-->
                <li>
                    <!-- proxima pagina -->
                    <?php
                    if ($proxima <= $num_pagina) { ?>
                        <a href="index.php#session2?pagina=<?php echo $proxima; ?>" aria-label="Previous">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    <?php } else { ?>
                        <span aria-hidden="true">&raquo;</span>
                    <?php }  ?>
                    <!-- fim proxima pagina -->
                </li>
            </ul>
        </nav>
        <!-- fim da paginação -->
    </div>
</body>

</html>