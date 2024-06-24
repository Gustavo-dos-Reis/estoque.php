<?php
    $servidor = "localhost";
    $usuario = "root";
    $senha = "123456";
    $banco = "estoque";

    $Link = new mysqli($servidor, $usuario, $senha, $banco);

    if($Link->connect_error) {
        die("Falha ao conectar: " . $Link->connect_error);
    }
?>
