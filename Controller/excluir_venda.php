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

    $sql = "SELECT codigo_produto, quantidade FROM venda WHERE id = ?";
    $stmt = mysqli_prepare($Link, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $codigo_produto = $row['codigo_produto'];
            $quantidade_venda = $row['quantidade'];

            $sql_delete = "DELETE FROM venda WHERE id = ?";
            $stmt_delete = mysqli_prepare($Link, $sql_delete);
            mysqli_stmt_bind_param($stmt_delete, "i", $id);
            
            if (mysqli_stmt_execute($stmt_delete)) {
                $sql_update = "UPDATE item SET quantidade = quantidade + ? WHERE codigo_produto = ?";
                $stmt_update = mysqli_prepare($Link, $sql_update);
                mysqli_stmt_bind_param($stmt_update, "is", $quantidade_venda, $codigo_produto);

                if (mysqli_stmt_execute($stmt_update)) {
                    header('Location: ../venda.php');
                } else {
                    showError("Erro ao atualizar a quantidade do produto: " . mysqli_error($Link));
                }
            } else {
                showError("Erro ao excluir a venda: " . mysqli_error($Link));
            }

            mysqli_stmt_close($stmt_delete);
            mysqli_stmt_close($stmt_update);
        } else {
            showError("Erro ao obter os dados da venda.");
        }

        mysqli_stmt_close($stmt);
    } else {
        showError("Erro ao preparar a consulta: " . mysqli_error($Link));
    }
} else {
    showError("ID da venda não fornecido.");
}

mysqli_close($Link);
?>
