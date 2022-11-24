<?php
include 'conecta.php';

// Criando consulta SQL
$consultaSql = "SELECT * FROM cliente where deleted is null order by nome, cpf asc";
$consultaSqlArq = "SELECT * FROM cliente where deleted is not null order by nome, cod_cliente asc";

// Buscando e listando os dados da tabela (completa)
$lista = $pdo->query($consultaSql);
$listaArq = $pdo->query($consultaSqlArq);

// Separar em linhas
$row = $lista->fetch();
$rowArq = $listaArq->fetch();

// Retornando o número de linhas
$num_rows = $lista->rowCount();

// Busca cliente por código
$nome = "";
$cpf = "";
$cod = 0;

if (isset($_GET['codedit'])) {
    $queryEdit = "SELECT * FROM cliente where cod_cliente=".$_GET['codedit'];
    $cliente = $pdo->query($queryEdit)->fetch();
    $cod = $_GET['codedit'];
    $nome = $cliente['nome'];
    $cpf = $cliente['cpf'];
    // echo "<h1>Você vai editar o cliente ".$_GET['codedit']."</h1>";
}

// Comando para incluir campo deleted na tabela cliente
// Alter table cliente add deleted datetime null;

// Código para arquivar(excluir)
if (isset($_GET['codarq'])) 
{
    $queryArq = "update cliente set deleted = now() where cod_cliente=".$_GET['codarq'];
    $cliente = $pdo->query($queryArq)->fetch();
    header('location: clientes.php');
}

// Restaurar o cliente
if (isset($_GET['codres'])) 
{
    $queryRes = "update cliente set deleted = null where cod_cliente=".$_GET['codres'];
    $cliente = $pdo->query($queryRes)->fetch();
    header('location: clientes.php');
}

// Remover definitivamente (LGPD)
if (isset($_GET['codexc']))
{
    $queryExc = "delete from cliente where cod_cliente=".$_GET['codexc'];
    $cliente = $pdo->query($queryExc)->fetch();
    header('location: clientes.php');
}

if (isset($_POST['enviar'])) // Inserir ou Alterar
{ // Insere o cliente
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $consulta = "insert cliente (nome, cpf) values ('$nome','$cpf')";
    $resultado = $pdo->query($consulta);
    $_POST['enviar'] = null;
    header('location: clientes.php');
}

if (isset($_POST['alterar'])) {
    // Altera os dados do cliente
    $cod = $_POST['cod-cliente'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $updateSql = "update cliente set nome = '$nome', cpf='$cpf' where cod_cliente = $cod";
    $resultado = $pdo->query($updateSql);
    header('location: clientes.php');
}


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Clientes (<?php echo $num_rows ?>)</title>
    <!-- <style>
        td{
            border-bottom: 1px solid red;
        }
    </style> -->
</head>

<body>
    <section>
        <!-- Card -->
        <div class="card" style="width: 18rem;">
            <div class="card-body d-grid gap-2">
                <img src="images/img2.png" class="card-img-top" alt="">
                <h5 class="card-title text-center">Dados do Cliente</h5>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Novo +
                </button>
            </div>
        </div>
    </section>
    <br>
    <h3 class="text-center">Clientes ativados</h3>
    <br>
    <table class="table table-secondary table-striped table-hover">
        <thead>
                <th hidden>Cod</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Ações</th>
                <th colspan="2" class="text-center">Ações</th>
        </thead>
        <tbody>
            <?php do { ?>
                <tr>
                    <td hidden><?php echo $row['cod_cliente']; ?></td>
                    <td><?php echo $row['nome']; ?></td>
                    <td><?php echo $row['cpf']; ?></td>
                    <td><a type="button" class="btn btn-primary" href="clientes.php?codedit=<?php echo $row['cod_cliente']; ?>">Editar</a></td>
                    <td><a type="button" class="btn btn-primary" href="clientes.php?codarq=<?php echo $row['cod_cliente']; ?>">Arquivar</a></td>
                </tr>
        <?php } while ($row = $lista->fetch()) ?>
        </tbody>
    </table>
    <br>
    <h3 class="text-center">Clientes arquivados</h3>
    <br>
    <table class="table table-secondary table-striped table-hover">
        <thead>
            <th hidden>Cod</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Arquivado em:</th>
            <th colspan="2" class="text-center">Ações</th>
        </thead>
        <tbody>
            <?php do { ?>
                <tr>
                    <td hidden><?php echo $rowArq['cod_cliente']; ?></td>
                    <td><?php echo $rowArq['nome']; ?></td>
                    <td><?php echo $rowArq['cpf']; ?></td>
                    <td><?php echo $rowArq['deleted']; ?></td>
                    <td><a type="button" class="btn btn-primary" href="clientes.php?codres=<?php echo $rowArq['cod_cliente']; ?>">Restaurar</a></td>
                    <td><a type="button" class="btn btn-primary" href="clientes.php?codexc=<?php echo $rowArq['cod_cliente']; ?>">Excluir</a></td>
                </tr>
            <?php } while ($rowArq = $listaArq->fetch()) ?>
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Clientes Arquivados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" class="form-control">
                        <div hidden>
                            <label for="cod-cliente">
                                Código
                                <input class="form-control" type="text" name="cod-cliente" value="<?php echo $cod; ?>">
                            </label>
                        </div>
                        <div class="row mb-3">
                            <label for="nome">
                                Nome
                                <input class="form-control" type="text" name="nome" required value="<?php echo $nome; ?>">
                            </label>
                        </div>
                        <div class="row mb-3">
                            <label for="cpf">
                                CPF
                                <input class="form-control" type="number" name="cpf" required value="<?php echo $cpf; ?>">
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