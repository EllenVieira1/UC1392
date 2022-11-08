<?php

include ('config.php');

include ('funcoes.php');

// "/* */" Comentário de bloco
// "//" Comentário de linha
// "#" Comentário de linha

// Inicio - Declaração de variáveis 

// echo parcelar(10,4); // 10% em 4 parcelas
// echo ('<br>');
// date_default_timezone_set('America/Sao_Paulo');
// $nome = "Ellen";
// $data_nasc = date('2003/12/11');
// echo($nome. " - " .$data_nasc);
// echo('<br>');
// $hoje = date("d-m-y H:i:s");
// echo($hoje);
// echo('<br>');

/*
$date = date_create('2000-01-01', timezone_open('America/Sao_Paulo'));
echo date_format($date, 'Y-m-d H:i:sP') . "\n";

echo('<br>');

date_timezone_set($date, timezone_open('Pacific/Chatham'));
echo date_format($date, 'Y-m-d H:i:sP') . "\n";
*/

// $valor = 78.98;
// $idade = 32;
// $teste = true;

// Final - Declaração de variáveis 

// Inicio - Desclaração de uso de matrizes

// echo('<br>');
// $alunos = array();
// $alunos[0] = "Maria";
// $alunos[1] = "João";
// $nota = array(9,8,7,4);
// print_r($nota);
// echo('<br>');
// $pontos = array('José'=>'11', 'Lucas'=>'5', 'Jean'=>'9');
// print_r($pontos);
// echo('<br>');

// Final - Desclaração de uso de matrizes

// Inicio - Estrutura de decisão

// echo('<br>');
// if (!($idade>=30)){ // Se verdadeiro então
//     echo("Aluno em lista de classificação");
// }
// $a = 1; $b = 15;
// if($a > $b){
//     echo("A valor '$a' é maior que '$b'");
// }elseif($a < $b){
//     echo("O valor '$a' é menor que '$b'");
// }else{
//     echo("O valor '$a' é igual a '$b'");
// }
// echo('<br>');
// $n = 9;

// Final - Estrutura de decisão

// Inico - Estruturas de repetição

// echo('<br>');
// while ($a < 11) {
//     echo($n.' x '.$a." = ".($a*$n)."<br>");
//     $a = $a +1;
// }
// echo('<br>');
// for ($i=1; $i < 11; $i++) {
//     echo($n.' x '.$i." = ".($i*$n)."<br>");
// }
// echo('<br>');
// $nota = array(9,8,7,4);

// for ($i=0; $i < 4; $i++) {
//     echo($nota[$i]);
//     echo('<br>');
// }

// Eu uso a estrutura WHILE quando eu não conheço o limite.

// Final - Estruturas de repetição

// Inicio - Desclaração de uso de matrizes

$pessoas = array(
    '98H47O'=>(['Well', 'Professor']), 
    '25P45F'=>(['Paloma', 'Castro']), 
    '36K89L'=>(['Ellen', 'Vieira']), 
    '10M56T'=>(['Helen', 'Targino'])
);

// Final - Desclaração de uso de matrizes

if (isset($_POST['enviar'])){ // Se o usuário clicar no botão
    $id_frm = $_POST['id'];
    $nome_frm = $_POST['nome'];
    $sobre_frm = $_POST['sobrenome'];
    $pessoas += [$id_frm => ([$nome_frm, $sobre_frm])];
}
// echo('<br>');
// print_r($_GET);
// echo('<br>');

?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <!-- <meta http-equiv="refresh" content="1"> -->
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <br>
        <form action="aula4.php" method="post">
            <button type="submit">Parcelamento</button>
            <br>
            <hr>
        </form>
        <form action="#" method="post">
            <label for="id">
                ID
                <input type="text" name="id" placeholder="Entre com o ID." required>
            </label><br>
            <label for="nome">
                Nome
                <input type="text" name="nome" required>
            </label><br>
            <label for="sobrenome">
                Sobrenome
                <input type="text" name="sobrenome">
            </label><br>
            <button type="submit" name="enviar" id="btn-enviar">Enviar</button>
        </form>
        <table class="tabelinha">
            <th>ID</th>
            <th>Nome</th>
            <th>Sobrenome</th>
            <!-- <th>E-Mail</th> -->
            <tr>
                <td>23A28Y</td>
                <td>Mayara</td>
                <td>Raisa</td>
                <!-- <td>nath@gmail.com</td> -->
            </tr>
            <?php foreach ($pessoas as $id => $nome) { ?>
                <tr>
                    <td><?php echo($id);?></td>
                    <td><?php echo($nome[0]);?></td>
                    <td><?php echo($nome[1]);?></td>
                </tr>
            <?php } ?>
        </table>
    </body>
</html>