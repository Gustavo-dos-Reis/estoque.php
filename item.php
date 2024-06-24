<?php include_once "./Controller/conexao.php"; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Item</title>
    <link rel="stylesheet" href="./css/estoque.css">
</head>
<body>
    <header>
        <h1>Registrar Novo Item</h1>            
    </header>
    <div id="main-container" class="flex-container">
        <section>
            <form method="post" action="item.php" class="form-container">
                <div class="form-group">
                    <input type="text" class="form-control" name="codigo_produto" placeholder="Código do Produto..." required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="nome" placeholder="Nome do Produto..." required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="tipo" placeholder="Tipo do Produto...">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="marca" placeholder="Marca do Produto...">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="modelo" placeholder="Modelo do Produto...">
                </div>
                <div class="buttons-container">
                    <button type="submit" class="btn btn-primary form-control">Registrar Item</button>
                    <input type="button" class="btn btn-secondary" value="Voltar ao Menu" onclick="window.open('index.html','_self')">
                </div>
            </form>
        </section>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include "./Controller/item.php";
    }
    ?>

    <div class="table-container">
        <h2>Itens em Estoque</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Código do Produto</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Quantidade</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT codigo_produto, nome, tipo, marca, modelo, quantidade, valor FROM item";
                    $result = mysqli_query($Link, $sql);
                    while ($row = mysqli_fetch_assoc($result)){
                        echo "
                            <tr class='table-light'>
                                <td>{$row['codigo_produto']}</td>
                                <td>{$row['nome']}</td>
                                <td>{$row['tipo']}</td>
                                <td>{$row['marca']}</td>
                                <td>{$row['modelo']}</td>
                                <td>{$row['quantidade']}</td>
                                <td>{$row['valor']}</td>
                            </tr>
                        ";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
