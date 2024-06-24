<?php
include_once "../Controller/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data_compra = $_POST['data_compra'];
    $numero_da_compra = $_POST['numero_da_compra'];
    $fornecedor = $_POST['fornecedor'];
    $codigo_produto_compra = $_POST['codigo_produto_compra'];
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];

    // Verificar se o código do produto existe na tabela item
    $sql_verifica_produto = "SELECT * FROM item WHERE codigo_produto = '$codigo_produto_compra'";
    $resultado_verifica = mysqli_query($Link, $sql_verifica_produto);

    if (mysqli_num_rows($resultado_verifica) > 0) {
        // Inserir na tabela compra
        $sql_compra = "INSERT INTO compra (data_compra, numero_da_compra, fornecedor, codigo_produto_compra, quantidade, valor) 
                       VALUES ('$data_compra', '$numero_da_compra', '$fornecedor', '$codigo_produto_compra', $quantidade, $valor)";

        if (mysqli_query($Link, $sql_compra)) {
            // Atualizar quantidade e valor na tabela item
            $sql_atualiza_item = "UPDATE item SET quantidade = $quantidade, valor = $valor 
                                  WHERE codigo_produto = '$codigo_produto_compra'";
            if (mysqli_query($Link, $sql_atualiza_item)) {
                header("Location: ../compra.php");
                exit();
            } else {
                echo "Erro ao atualizar a tabela item: " . mysqli_error($Link);
            }
        } else {
            echo "Erro ao registrar a compra: " . mysqli_error($Link);
        }
    } else {
        echo "Código do produto '$codigo_produto_compra' não encontrado na tabela item.";
    }
} else {
    echo "Por favor, preencha todos os campos corretamente.";
}
?>