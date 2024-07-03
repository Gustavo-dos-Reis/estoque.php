<?php
include_once "./conexao.php";

function showError($message) {
    echo "<script>
            alert('$message');
            window.history.back();
          </script>";
    exit();
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "SELECT codigo_produto_compra AS codigo_produto, quantidade, valor FROM compra WHERE id = ?";
    $stmt = mysqli_prepare($Link, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $codigo_produto = $row['codigo_produto'];
            $quantidade_compra = $row['quantidade'];
            $valor_compra = $row['valor'];

            $sql_delete = "DELETE FROM compra WHERE id = ?";
            $stmt_delete = mysqli_prepare($Link, $sql_delete);
            mysqli_stmt_bind_param($stmt_delete, "i", $id);
            
            if (mysqli_stmt_execute($stmt_delete)) {
                $sql_update = "UPDATE item SET quantidade = quantidade - ? WHERE codigo_produto = ?";
                $stmt_update = mysqli_prepare($Link, $sql_update);
                mysqli_stmt_bind_param($stmt_update, "is", $quantidade_compra, $codigo_produto);

                if (mysqli_stmt_execute($stmt_update)) {
                    $sql_media = "SELECT AVG(valor) as media_valor FROM compra WHERE codigo_produto_compra = ?";
                    $stmt_media = mysqli_prepare($Link, $sql_media);
                    mysqli_stmt_bind_param($stmt_media, "s", $codigo_produto);
                    mysqli_stmt_execute($stmt_media);
                    $result_media = mysqli_stmt_get_result($stmt_media);
                    $row_media = mysqli_fetch_assoc($result_media);
                    $media_valor = $row_media['media_valor'];

                    $sql_update_valor = "UPDATE item SET valor = ? WHERE codigo_produto = ?";
                    $stmt_update_valor = mysqli_prepare($Link, $sql_update_valor);
                    mysqli_stmt_bind_param($stmt_update_valor, "ds", $media_valor, $codigo_produto);

                    if (mysqli_stmt_execute($stmt_update_valor)) {
                        header('Location: ../compra.php');
                    } else {
                        showError("Erro ao atualizar o valor médio do produto: " . mysqli_error($Link));
                    }
                } else {
                    showError("Erro ao atualizar a quantidade do produto: " . mysqli_error($Link));
                }
            } else {
                showError("Erro ao excluir a compra: " . mysqli_error($Link));
            }

            mysqli_stmt_close($stmt_delete);
            mysqli_stmt_close($stmt_update);
            mysqli_stmt_close($stmt_media);
            mysqli_stmt_close($stmt_update_valor);
        } else {
            showError("Erro ao obter os dados da compra.");
        }

        mysqli_stmt_close($stmt);
    } else {
        showError("Erro ao preparar a consulta: " . mysqli_error($Link));
    }
} else {
    showError("ID da compra não fornecido.");
}

mysqli_close($Link);
?>
