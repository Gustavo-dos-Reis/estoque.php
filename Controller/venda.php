<?php
include_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data_venda = $_POST['data_venda'];
    $cliente = $_POST['cliente'];
    $numero_da_venda = $_POST['numero_da_venda'];
    $produto_id = $_POST['produto_id'];
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];

    // Verifique se os campos não estão vazios e se a quantidade e valor são válidos
    if (!empty($data_venda) && !empty($cliente) && !empty($numero_da_venda) && !empty($produto_id) && !empty($quantidade) && $quantidade > 0 && !empty($valor) && $valor > 0) {
        // Verifica se o produto existe e se a quantidade é suficiente
        $sql_verifica_produto = "SELECT * FROM item WHERE id = $produto_id";
        $resultado_verifica = mysqli_query($Link, $sql_verifica_produto);

        if (mysqli_num_rows($resultado_verifica) > 0) {
            $produto = mysqli_fetch_assoc($resultado_verifica);
            if ($produto['quantidade'] >= $quantidade) {
                // Atualiza a quantidade do produto no estoque
                $sql_atualiza_item = "UPDATE item SET quantidade = quantidade - $quantidade WHERE id = $produto_id";
                if (mysqli_query($Link, $sql_atualiza_item)) {
                    // Registra a venda na tabela venda
                    $produto_nome = $produto['nome']; // Nome do produto
                    
                    $sql_venda = "INSERT INTO venda (data_venda, numero_da_venda, cliente, produto, codigo_produto, quantidade, valor) 
                                  VALUES ('$data_venda', '$numero_da_venda', '$cliente', '$produto_nome', '{$produto['codigo_produto']}', $quantidade, $valor)";
                    if (mysqli_query($Link, $sql_venda)) {
                        // Redireciona de volta para venda.php após a atualização bem-sucedida
                        header("Location: ../venda.php");
                        exit();
                    } else {
                        echo "Erro ao registrar venda: " . mysqli_error($Link);
                    }
                } else {
                    echo "Erro ao registrar saída: " . mysqli_error($Link);
                }
            } else {
                echo "Quantidade insuficiente no estoque.";
            }
        } else {
            echo "Produto não encontrado.";
        }
    } else {
        echo "Por favor, preencha todos os campos corretamente.";
    }
}
?>
