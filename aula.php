<?php
    include "aula2.php";
    $premio = 1547.90;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aula 2 - UC13</title>
</head>
<body>
    
    <table>
        <th>ID</th>
        <th>Nome</th>
        <th>Telefone</th>
        <th>Prêmio</th>
        <tr>
            <td>1254</td>
            <td>Ellen</td>
            <td>2185-9200</td>
            <td><?php echo($premio * 0.12); ?></td>
        </tr>
        <tr>
            <td>1298</td>
            <td>Mayara</td>
            <td>2185-9231</td>
            <td><?php echo($premio * 0.28); ?></td>
        </tr>
        <tr>
            <td>1285</td>
            <td><?php echo($nome);?></td>
            <td>2185-9252</td>
            <td><?php echo($premio * 0.7); ?></td>
        </tr>
    </table>

</body>
</html>