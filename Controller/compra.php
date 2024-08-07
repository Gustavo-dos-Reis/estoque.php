<?php
include_once "../Controller/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data_compra = $_POST['data_compra'];
    $numero_da_compra = $_POST['numero_da_compra'];
    $fornecedor = $_POST['fornecedor'];
    $codigo_produto_compra = $_POST['codigo_produto_compra'];
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];

    // Sanitize inputs
    $data_compra = mysqli_real_escape_string($Link, $data_compra);
    $numero_da_compra = mysqli_real_escape_string($Link, $numero_da_compra);
    $fornecedor = mysqli_real_escape_string($Link, $fornecedor);
    $codigo_produto_compra = mysqli_real_escape_string($Link, $codigo_produto_compra);
    $quantidade = filter_var($quantidade, FILTER_VALIDATE_INT);
    $valor = filter_var($valor, FILTER_VALIDATE_FLOAT);

    if ($quantidade === false || $valor === false) {
        echo "<script>
                alert('Quantidade ou valor inválido.');
                window.location.href = 'http://localhost/Estoque/compra.php';
              </script>";
        exit();
    }

    // Verificar se o código do produto existe na tabela item
    $sql_verifica_produto = "SELECT * FROM item WHERE codigo_produto = '$codigo_produto_compra'";
    $resultado_verifica = mysqli_query($Link, $sql_verifica_produto);

    if (mysqli_num_rows($resultado_verifica) > 0) {
        // Verificar se o número da compra já existe na tabela compra
        $sql_verifica_compra = "SELECT * FROM compra WHERE numero_da_compra = '$numero_da_compra'";
        $resultado_compra = mysqli_query($Link, $sql_verifica_compra);

        if (mysqli_num_rows($resultado_compra) > 0) {
            echo "<script>
                    alert('Número da compra \"$numero_da_compra\" já existe. Por favor, insira um número diferente.');
                    window.location.href = 'http://localhost/Estoque/compra.php';
                  </script>";
        } else {
            // Inserir na tabela compra
            $sql_compra = "INSERT INTO compra (data_compra, numero_da_compra, fornecedor, codigo_produto_compra, quantidade, valor) 
                           VALUES ('$data_compra', '$numero_da_compra', '$fornecedor', '$codigo_produto_compra', $quantidade, $valor)";

            if (mysqli_query($Link, $sql_compra)) {
                // Atualizar quantidade na tabela item
                $sql_atualiza_item = "UPDATE item SET quantidade = COALESCE(quantidade, 0) + $quantidade, valor = $valor 
                                      WHERE codigo_produto = '$codigo_produto_compra'";
                if (mysqli_query($Link, $sql_atualiza_item)) {
                    echo "<script>
                            alert('Compra registrada com sucesso!');
                            window.location.href = 'http://localhost/Estoque/compra.php';
                          </script>";
                } else {
                    echo "<script>
                            alert('Erro ao atualizar a tabela item: " . mysqli_error($Link) . "');
                            window.location.href = 'http://localhost/Estoque/compra.php';
                          </script>";
                }
            } else {
                $error_message = mysqli_error($Link);
                if (strpos($error_message, "Out of range value for column 'quantidade'") !== false) {
                    echo "<script>
                            alert('Erro ao registrar a compra: Valor fora do intervalo permitido para a quantidade.');
                            window.location.href = 'http://localhost/Estoque/compra.php';
                          </script>";
                } else {
                    echo "<script>
                            alert('Erro ao registrar a compra: " . $error_message . "');
                            window.location.href = 'http://localhost/Estoque/compra.php';
                          </script>";
                }
            }
        }
    } else {
        echo "<script>
                alert('Código do produto \"$codigo_produto_compra\" não encontrado na tabela item.');
                window.location.href = 'http://localhost/Estoque/compra.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Por favor, preencha todos os campos corretamente.');
            window.location.href = 'http://localhost/Estoque/compra.php';
          </script>";
}
?>