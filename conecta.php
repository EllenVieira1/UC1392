<?php
include 'config.php';

// Dados de Acesso - db_locadora
// $banco = "db_locadora";
// $server = "127.0.0.1";
// $senha = "";
// $user_db = "root";

try {
    //Testa
    $pdo = new PDO("mysql:dbname=".DATABASE.";port=3306;host=".SERVER_DB,USER_DB,SENHA_DB);
} catch (Exception $e) {
    //Caso de Falha
    echo "Falha ao conectar ao banco".DATABASE.".Verifique! - ".$e;
}

?>