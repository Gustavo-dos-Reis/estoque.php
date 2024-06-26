<?php
include_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data_venda = $_POST['data_venda'];
    $cliente = $_POST['cliente'];
    $numero_da_venda = $_POST['numero_da_venda'];
    $produto_id = $_POST['produto_id'];
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];

    if (!empty($data_venda) && !empty($cliente) && !empty($numero_da_venda) && !empty($produto_id) && !empty($quantidade) && $quantidade > 0 && !empty($valor) && $valor > 0) {
        // Verifique se o número da venda já existe
        $sql_verifica_numero_venda = "SELECT * FROM venda WHERE numero_da_venda = '$numero_da_venda'";
        $resultado_verifica_numero = mysqli_query($Link, $sql_verifica_numero_venda);

        if (mysqli_num_rows($resultado_verifica_numero) > 0) {
            echo "<script>
                    alert('Número da venda já existe. Por favor, escolha outro número.');
                    window.location.href = 'http://localhost/Estoque/venda.php';
                  </script>";
            exit();
        }

        $sql_verifica_produto = "SELECT * FROM item WHERE id = $produto_id";
        $resultado_verifica = mysqli_query($Link, $sql_verifica_produto);

        if (mysqli_num_rows($resultado_verifica) > 0) {
            $produto = mysqli_fetch_assoc($resultado_verifica);
            if ($produto['quantidade'] >= $quantidade) {
                $sql_atualiza_item = "UPDATE item SET quantidade = quantidade - $quantidade WHERE id = $produto_id";
                if (mysqli_query($Link, $sql_atualiza_item)) {
                    $produto_nome = $produto['nome'];

                    $sql_venda = "INSERT INTO venda (data_venda, numero_da_venda, cliente, produto, codigo_produto, quantidade, valor) 
                                  VALUES ('$data_venda', '$numero_da_venda', '$cliente', '$produto_nome', '{$produto['codigo_produto']}', $quantidade, $valor)";
                    if (mysqli_query($Link, $sql_venda)) {
                        echo "<script>
                                alert('Venda registrada com sucesso!');
                                window.location.href = 'http://localhost/Estoque/venda.php';
                              </script>";
                    } else {
                        echo "<script>
                                alert('Erro ao registrar venda: " . mysqli_error($Link) . "');
                                window.location.href = 'http://localhost/Estoque/venda.php';
                              </script>";
                    }
                } else {
                    echo "<script>
                            alert('Erro ao registrar saída: " . mysqli_error($Link) . "');
                            window.location.href = 'http://localhost/Estoque/venda.php';
                          </script>";
                }
            } else {
                echo "<script>
                        alert('Quantidade insuficiente no estoque.');
                        window.location.href = 'http://localhost/Estoque/venda.php';
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Produto não encontrado.');
                    window.location.href = 'http://localhost/Estoque/venda.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Por favor, preencha todos os campos corretamente.');
                window.location.href = 'http://localhost/Estoque/venda.php';
              </script>";
    }
}
?>
