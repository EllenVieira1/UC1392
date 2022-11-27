<?php
include 'conecta.php';

// Criando consulta SQL
$consultaSql = "SELECT * FROM vw_filme_class";
$consultaSqlArq = "SELECT * FROM filme where deleted is not null order by titulo, cod_filme asc";


// Traz as listas completa dos dados
$lista = $pdo->query($consultaSql);
$listaClass = $pdo->query("select cod_classificacao as id, classificacoes as class from classificacao");
$listaArq = $pdo->query($consultaSqlArq);

// Separar os dados em linhas
$row = $lista->fetch();
$rowClass = $listaClass->fetch();
$rowArq = $listaArq->fetch();

// Retornando o número de linhas
$num_rows = $lista->rowCount();

// Busca filme por código
$titulo = "";
$sinopse = "";
$lancamento = "";
$pais_origem = "";
$duracao = "";
$preco = "";
$cod_classificacao = "";
$cod = 0;

// echo 'A consulta retornou <strong>'.$num_linhas.'</strong> Filmes <br>';
// echo '<br>';
// print_r($linha);

// do {
//     echo $linha['titulo'].' - '.$linha['lancamento'].'<br>';
// } while ($linha = $lista->fetch());

if (isset($_GET['codedit'])) {
    $queryEdit = "SELECT * FROM filme where cod_filme=" . $_GET['codedit'];
    $filme = $pdo->query($queryEdit)->fetch();
    $cod = $_GET['codedit'];
    $titulo = $filme['titulo'];
    $sinopse = $filme['sinopse'];
    $lancamento = $filme['lancamento'];
    $pais_origem = $filme['pais_origem'];
    $duracao = $filme['duracao'];
    $preco = $filme['preco'];
    $cod_classificacao = $filme['cod_classificacao'];
    // echo "<h1>Você vai editar o filme ".$_GET['codedit']."</h1>";
}

// Comando para incluir campo deleted na tabela filme
// Alter table filme add deleted datetime null;

// Código para arquivar(excluir)
if (isset($_GET['codarq'])) {
    $queryArq = "update filme set deleted = now() where cod_filme=" . $_GET['codarq'];
    $filme = $pdo->query($queryArq)->fetch();
    header('location: filmes.php');
}

// Restaurar o filme
if (isset($_GET['codres'])) {
    $queryRes = "update filme set deleted = null where cod_filme=" . $_GET['codres'];
    $filme = $pdo->query($queryRes)->fetch();
    header('location: filmes.php');
}

// Remover definitivamente (LGPD)
if (isset($_GET['codexc'])) {
    $queryExc = "delete from filme where cod_filme=" . $_GET['codexc'];
    $filme = $pdo->query($queryExc)->fetch();
    header('location: filmes.php');
}

if (isset($_POST['enviar'])) // Inserir ou Alterar
{
    $titulo = $_POST['titulo'];
    $sinopse = $_POST['sinopse'];
    $lancamento = $_POST['lancamento'];
    $pais_origem = $_POST['pais_origem'];
    $duracao = $_POST['duracao'];
    $preco = $_POST['preco'];
    $cod_classificacao = $_POST['class'];
    $consulta = "insert filme (titulo, sinopse, lancamento, pais_origem, duracao, preco, cod_classificacao) values ('$titulo','$sinopse','$lancamento','$pais_origem','$duracao','$preco','$cod_classificacao')";
    $resultado = $pdo->query($consulta);
    $_POST['enviar'] = null;
    header('location: filmes.php');
}

if (isset($_POST['alterar'])) {
    // Altera os dados do cliente
    $cod = $_POST['cod-filme'];
    $titulo = $_POST['titulo'];
    $sinopse = $_POST['sinopse'];
    $lancamento = $_POST['lancamento'];
    $pais_origem = $_POST['pais_origem'];
    $duracao = $_POST['duracao'];
    $preco = $_POST['preco'];
    $cod_classificacao = $_POST['class'];
    $updateSql = "update filme set titulo ='$titulo', sinopse='$sinopse', lancamento='$lancamento', pais_origem='$pais_origem', duracao='$duracao', preco='$preco', cod_classificacao='$cod_classificacao' where cod_filme = $cod";
    $resultado = $pdo->query($updateSql);
    header('location: filmes.php');
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Filmes (<?php echo $num_rows ?>)</title>
    <!-- <style>
        td{
            border-bottom: 1px solid burlywood;
        }
    </style> -->
</head>

<body>
    <section>
        <!-- Card -->
        <div class="card" style="width: 18rem;">
            <div class="card-body d-grid gap-2">
                <img src="images/img1.jpg" class="card-img-top" alt="">
                <h5 class="card-title text-center">Cadastro de Filmes</h5>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Novo +
                </button>
            </div>
        </div>
    </section>
    <br>
    <h3 class="text-center">Filmes Ativados</h3>
    <br>
    <table class="table table-secondary table-striped table-hover">
        <thead>
            <th hidden>ID</th>
            <th>Título</th>
            <th>Sinopse</th>
            <th>Lançamento</th>
            <th>País de Origem</th>
            <th>Duração</th>
            <th>Preço</th>
            <th>Classificação</th>
            <th colspan="2" class="text-center">Ações</th>
        </thead>
        <tbody>
            <?php do { ?>
                <tr>
                    <td hidden><?php echo $row['cod_filme']; ?></td>
                    <td><?php echo $row['titulo']; ?></td>
                    <td><?php echo $row['sinopse']; ?></td>
                    <td><?php echo $row['lancamento']; ?></td>
                    <td><?php echo $row['pais_origem']; ?></td>
                    <td><?php echo $row['duracao']; ?></td>
                    <td><?php echo $row['preco']; ?></td>
                    <td><?php echo $row['classificacao']; ?></td>
                    <td><a type="button" class="btn btn-primary" href="filmes.php?codedit=<?php echo $row['cod_filme']; ?>">Editar</a></td>
                    <td><a type="button" class="btn btn-primary" href="filmes.php?codarq=<?php echo $row['cod_filme']; ?>">Arquivar</a></td>
                </tr>
            <?php } while ($row = $lista->fetch()) ?>
        </tbody>
    </table>
    <br>
    <h3 class="text-center">Filmes Arquivados</h3>
    <br>
    <table class="table table-secondary table-striped table-hover">
        <thead>
            <th hidden>ID</th>
            <th>Título</th>
            <th>Sinopse</th>
            <th>Lançamento</th>
            <th>País de Origem</th>
            <th>Duração</th>
            <th>Preço</th>
            <th>Classificação</th>
            <th>Arquivado em:</th>
            <th colspan="2" class="text-center">Ações</th>
        </thead>
        <tbody>
            <?php do { ?>
                <tr>
                    <td hidden><?php echo $rowArq['cod_filme']; ?></td>
                    <td><?php echo $rowArq['titulo']; ?></td>
                    <td><?php echo $rowArq['sinopse']; ?></td>
                    <td><?php echo $rowArq['lancamento']; ?></td>
                    <td><?php echo $rowArq['pais_origem']; ?></td>
                    <td><?php echo $rowArq['duracao']; ?></td>
                    <td><?php echo $rowArq['preco']; ?></td>
                    <td><?php echo $rowArq['cod_classificacao']; ?></td>
                    <td><?php echo $rowArq['deleted']; ?></td>
                    <td><a type="button" class="btn btn-primary" href="filmes.php?codres=<?php echo $rowArq['cod_filme']; ?>">Restaurar</a></td>
                    <td><a type="button" class="btn btn-primary" href="filmes.php?codexc=<?php echo $rowArq['cod_filme']; ?>">Excluir</a></td>
                </tr>
            <?php } while ($rowArq = $listaArq->fetch()) ?>
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Cadastro de Filmes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" class="form-control">
                        <div hidden>
                            <label for="cod-filme">
                                Código
                                <input type="text" name="cod-filme">
                            </label>
                        </div>
                        <div class="row mb-3">
                            <label for="titulo">
                                Título
                                <input class="form-control" type="text" name="titulo" required>
                            </label>
                        </div>
                        <div class="row mb-3">
                            <label for="sinopse">
                                Sinopse
                                <input class="form-control" type="textarea" name="sinopse" required>
                            </label>
                        </div>
                        <div class="row mb-3">
                            <label for="lancamento">
                                Lançamento
                                <input class="form-control" type="text" name="lancamento" required>
                            </label>
                        </div>
                        <div class="row mb-3">
                            <label for="pais_origem">
                                País de Origem
                                <input class="form-control" type="text" name="pais_origem" required>
                            </label>
                        </div>
                        <div class="row mb-3">
                            <label for="duracao">
                                Duração
                                <input class="form-control" type="text" name="duracao" required>
                            </label>
                        </div>
                        <div class="row mb-3">
                            <label for="preco">
                                Preço
                                <input class="form-control" type="text" name="preco" required>
                            </label>
                        </div>
                        <div class="row mb-3">
                            <label for="classificacao">
                                Classificação
                                <select name="class" id="" class="form-control">
                                    <?php do { ?>
                                        <option value="<?php echo $rowClass['id'] ?>"><?php echo $rowClass['class'] ?></option>
                                    <?php } while ($rowClass = $listaClass->fetch()); ?>
                                </select>
                            </label>
                        </div>
                        <div class="row mb-3">
                            <!-- Usamos o if ternário para trocar texto do botão -->
                            <button class="btn btn-outline-info" type="submit" name="<?php echo $cod < 1 ? 'enviar' : 'alterar'; ?>"><?php echo $cod < 1 ? 'Enviar' : 'Alterar'; ?></button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary">Restaurar</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>