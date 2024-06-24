<?php
include_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_produto = $_POST['codigo_produto'];
    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];

    if (!empty($codigo_produto) && !empty($nome)) {
        // Verifica se o código do produto já existe no banco de dados
        $sql_check = "SELECT * FROM item WHERE codigo_produto = '$codigo_produto'";
        $result_check = mysqli_query($Link, $sql_check);

        if (mysqli_num_rows($result_check) > 0) {
            echo "<p>Código do produto já existe. Por favor, insira um código diferente.</p>";
        } else {
            // Insere o item no banco de dados
            $sql = "INSERT INTO item (codigo_produto, nome, tipo, marca, modelo) 
                    VALUES ('$codigo_produto', '$nome', '$tipo', '$marca', '$modelo')";

            if (mysqli_query($Link, $sql)) {
                echo "<p>Item registrado com sucesso!</p>";
            } else {
                echo "Erro ao registrar o item: " . mysqli_error($Link);
            }
        }
    } else {
        echo "Por favor, preencha todos os campos obrigatórios.";
    }
}
?>
