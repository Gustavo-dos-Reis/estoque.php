<?php
include_once "conexao.php";

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
            die("Erro ao excluir o item: " . mysqli_error($Link));
        }
        
        mysqli_stmt_close($stmt);
    } else {
        die("Erro ao preparar a consulta: " . mysqli_error($Link));
    }
} else {
    die("ID do item não fornecido.");
}

mysqli_close($Link);
?>
