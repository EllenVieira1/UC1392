<?php
include 'conecta.php';

// Criando consulta SQL
$consulta = "SELECT * FROM funcionario where demissao is null";
$consultaSql = "SELECT * FROM funcionario where deleted is null order by nome, cpf asc";
$consultaSqlArq = "SELECT * FROM funcionario where deleted is not null order by nome, cod_func asc";

// Traz as listas completa dos dados
$lista = $pdo->query($consulta);
$listaArq = $pdo->query($consultaSqlArq);

// Separar os dados em linhas
$row = $lista->fetch();
$rowArq = $lista->fetch();

// Retornando o número de linhas
$num_rows = $lista->rowCount();

// Busca funcionário por código
$nome = "";
$cpf = "";
$cargo = "";
$escala = "";
$turno = "";
$admissao = "";
$salario = "";
$vt = "";
$vr = "";
$va = "";
$cod = 0;

if (isset($_GET['codedit'])) {
    $queryEdit = "SELECT * FROM funcionario where cod_func=" . $_GET['codedit'];
    $funcionario = $pdo->query($queryEdit)->fetch();
    $cod = $_GET['codedit'];
    $nome = $funcionario['nome'];
    $cpf = $funcionario['cpf'];
    $cargo = $funcionario['cargo'];;
    $escala = $funcionario['escala'];;
    $turno = $funcionario['turno'];;
    $admissao = $funcionario['admissao'];;
    $salario = $funcionario['salario'];;
    $vt = $funcionario['vt'];;
    $vr = $funcionario['vr'];;
    $va = $funcionario['va'];;
    // echo "<h1>Você vai editar o funcionário ".$_GET['codedit']."</h1>";
}

// Comando para incluir campo deleted na tabela funcionario
// Alter table funcionario add deleted datetime null;

// Código para arquivar(excluir)
if (isset($_GET['codarq'])) {
    $queryArq = "update funcionario set deleted = now() where cod_func=" . $_GET['codarq'];
    $funcionario = $pdo->query($queryArq)->fetch();
    header('location: funcionarios.php');
}

// Restaurar o funcionário
if (isset($_GET['codres'])) {
    $queryRes = "update funcionario set deleted = null where cod_func=" . $_GET['codres'];
    $funcionario = $pdo->query($queryRes)->fetch();
    header('location: funcionarios.php');
}

// Remover definitivamente (LGPD)
if (isset($_GET['codexc'])) {
    $queryExc = "delete from funcionario where cod_func=" . $_GET['codexc'];
    $funcionario = $pdo->query($queryExc)->fetch();
    header('location: funcionarios.php');
}

if (isset($_POST['enviar'])) // Inserir ou Alterar
{ // Insere o cliente
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $cargo = $_POST['cargo'];
    $escala = $_POST['escala'];
    $turno = $_POST['turno'];
    $admissao = $_POST['admissao'];
    $salario = $_POST['salario'];
    $vt = $_POST['vt'];
    $vr = $_POST['vr'];
    $va = $_POST['va'];
    $consulta = "insert funcionario (nome, cpf, cargo, escala, turno, admissao, salario, vt, vr, va) values ('$nome','$cpf','$cargo','$escala','$turno','$admissao','$salario','$vt','$vr','$va')";
    $resultado = $pdo->query($consulta);
    $_POST['enviar'] = null;
    header('location: funcionarios.php');
}

if (isset($_POST['alterar'])) {
    // Altera os dados do cliente
    $cod = $_POST['cod-funcionario'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $cargo = $_POST['cargo'];
    $escala = $_POST['escala'];
    $turno = $_POST['turno'];
    $admissao = $_POST['admissao'];
    $salario = $_POST['salario'];
    $vt = $_POST['vt'];
    $vr = $_POST['vr'];
    $va = $_POST['va'];
    $updateSql = "update funcionario set nome = '$nome', cpf='$cpf', cargo='$cargo', escala='$escala', turno='$turno', admissao='$admissao', salario='$salario', vt='$vt', vr='$vr', va='$va' where cod_func = $cod";
    $resultado = $pdo->query($updateSql);
    header('location: funcionarios.php');
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Funcionários (<?php echo $num_rows ?>)</title>
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
                <img src="images/img3.jpg" class="card-img-top" alt="">
                <h5 class="card-title text-center">Cadastro de Funcionários</h5>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Novo +
                </button>
            </div>
        </div>
    </section>
    <br>
    <h3 class="text-center">Funcionários Ativados</h3>
    <br>
    <table class="table table-secondary table-striped table-hover">
        <thead>
            <th hidden>ID</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Cargo</th>
            <th>Escala</th>
            <th>Turno</th>
            <th>Admissão</th>
            <!-- <th>Demissão</th> -->
            <th>Salario</th>
            <th>VT</th>
            <th>VR</th>
            <th>VA</th>
            <th colspan="2" class="text-center">Ações</th>
        </thead>
        <tbody>
            <?php do { ?>
                <tr>
                    <td hidden><?php echo $row['cod_func']; ?></td>
                    <td><?php echo $row['nome']; ?></td>
                    <td><?php echo $row['cpf']; ?></td>
                    <td><?php echo $row['cargo']; ?></td>
                    <td><?php echo $row['escala']; ?></td>
                    <td><?php echo $row['turno']; ?></td>
                    <td><?php echo $row['admissao']; ?></td>
                    <!-- <td><?php echo $row['demissao']; ?></td> -->
                    <td><?php echo $row['salario']; ?></td>
                    <td><?php echo $row['vt']; ?></td>
                    <td><?php echo $row['vr']; ?></td>
                    <td><?php echo $row['va']; ?></td>
                    <td><a type="button" class="btn btn-primary" href="funcionarios.php?codedit=<?php echo $row['cod_func']; ?>">Editar</a></td>
                    <td><a type="button" class="btn btn-primary" href="funcionarios.php?codarq=<?php echo $row['cod_func']; ?>">Arquivar</a></td>
                </tr>
            <?php } while ($row = $lista->fetch()) ?>
        </tbody>
    </table>
    <br>
    <h3 class="text-center">Funcionários Arquivados</h3>
    <br>
    <table class="table table-secondary table-striped table-hover">
        <thead>
            <th hidden>ID</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Cargo</th>
            <th>Escala</th>
            <th>Turno</th>
            <th>Admissão</th>
            <!-- <th>Demissão</th> -->
            <th>Salario</th>
            <th>VT</th>
            <th>VR</th>
            <th>VA</th>
            <th>Arquivado em:</th>
            <th colspan="2" class="text-center">Ações</th>
        </thead>
        <tbody>
            <?php do { ?>
                <tr>
                    <td hidden><?php echo $rowArq['cod_func']; ?></td>
                    <td><?php echo $rowArq['nome']; ?></td>
                    <td><?php echo $rowArq['cpf']; ?></td>
                    <td><?php echo $rowArq['cargo']; ?></td>
                    <td><?php echo $rowArq['escala']; ?></td>
                    <td><?php echo $rowArq['turno']; ?></td>
                    <td><?php echo $rowArq['admissao']; ?></td>
                    <!-- <td><?php echo $rowArq['demissao']; ?></td> -->
                    <td><?php echo $rowArq['salario']; ?></td>
                    <td><?php echo $rowArq['vt']; ?></td>
                    <td><?php echo $rowArq['vr']; ?></td>
                    <td><?php echo $rowArq['va']; ?></td>
                    <td><?php echo $rowArq['deleted']; ?></td>
                    <td><a type="button" class="btn btn-primary" href="funcionarios.php?codedit=<?php echo $row['cod_func']; ?>">Restaurar</a></td>
                    <td><a type="button" class="btn btn-primary" href="funcionarios.php?codarq=<?php echo $row['cod_func']; ?>">Excluir</a></td>
                </tr>
            <?php } while ($rowArq = $listaArq->fetch()) ?>
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Cadastro de Funcionários</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" class="form-control">
                        <div hidden>
                            <label for="cod-funcionario">
                                Código
                                <input type="text" name="cod-funcionario">
                            </label>
                        </div>
                        <div class="row mb-3">
                            <label for="nome">
                                Nome
                                <input class="form-control" type="text" name="nome" required>
                            </label>
                        </div>
                        <div class="row mb-3">
                            <label for="cpf">
                                CPF
                                <input class="form-control" type="text" name="cpf" required>
                            </label>
                        </div>
                        <div class="row mb-3">
                            <label for="cargo">
                                Cargo
                                <input class="form-control" type="text" name="cargo" required>
                            </label>
                        </div>
                        <div class="row mb-3">
                            <label for="escala">
                                Escala
                                <input class="form-control" type="text" name="escala" required>
                            </label>
                        </div>
                        <div class="row mb-3">
                            <label for="turno">
                                Turno
                                <input class="form-control" type="text" name="turno" required>
                            </label>
                        </div>
                        <div class="row mb-3">
                            <label for="admissao">
                                Admissão
                                <input class="form-control" type="text" name="admissao" required>
                            </label>
                        </div>
                        <div class="row mb-3">
                            <label for="salario">
                                Salario
                                <input class="form-control" type="text" name="salario" required>
                            </label>
                        </div>
                        <div class="row mb-3">
                        <label for="vt">
                                VT
                                <input class="form-control" type="text" name="vt" required>
                            </label>
                        </div>
                        <div class="row mb-3">
                        <label for="vr">
                                VR
                                <input class="form-control" type="text" name="vr" required>
                            </label>
                        </div>
                        <div class="row mb-3">
                        <label for="va">
                                VA
                                <input class="form-control" type="text" name="va" required>
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