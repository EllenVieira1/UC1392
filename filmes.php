<?php 
include 'conecta.php';

// Cria a consulta sql
$consulta = "select * from filme";

// Traz as listas completa dos dados
$lista = $pdo->query($consulta); 

// Separar os dados em linhas
$linha = $lista->fetch();
$num_linhas = $lista->rowCount();

// echo 'A consulta retornou <strong>'.$num_linhas.'</strong> Filmes <br>';
// echo '<br>';
// print_r($linha);

// do {
//     echo $linha['titulo'].' - '.$linha['lancamento'].'<br>';
// } while ($linha = $lista->fetch());
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Filmes (<?php echo $num_linhas ?>)</title>
    <!-- <style>
        td{
            border-bottom: 1px solid burlywood;
        }
    </style> -->
</head>
<body>
    <table>
        <thead>
            <th>ID</th>
            <th>Título</th>
            <th>Sinopse</th>
            <th>Lançamento</th>
        </thead>
        <tbody>
            <?php do { ?>
                <tr>
                    <td><?php echo $linha['cod_filme']?></td>
                    <td><?php echo $linha['titulo']?></td>
                    <td><?php echo $linha['sinopse']?></td>
                    <td><?php echo $linha['lancamento']?></td>
                </tr>
            <?php } while ($linha = $lista->fetch());?>
        </tbody>
    </table>
</body>
</html>