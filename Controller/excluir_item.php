<?php
include_once "conexao.php";

function showError($message) {
    echo "<script>
            alert('$message');
            window.history.back();
          </script>";
    exit();
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    $sql_delete = "DELETE FROM item WHERE id = ?";
    $stmt = mysqli_prepare($Link, $sql_delete);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        $result = mysqli_stmt_execute($stmt);
        
        if ($result) {
            header('Location: ../item.php');
        } else {
            showError("Erro ao excluir o item: " . mysqli_error($Link));
        }
        
        mysqli_stmt_close($stmt);
    } else {
        showError("Erro ao preparar a consulta: " . mysqli_error($Link));
    }
} else {
    showError("ID do item não fornecido.");
}

mysqli_close($Link);
?>
