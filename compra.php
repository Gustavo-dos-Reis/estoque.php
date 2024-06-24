<?php include_once "./Controller/conexao.php"; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Estoque</title>
    <link rel="stylesheet" href="./css/estoque.css">
</head>
<body>
    <header>
        <h1>Compras</h1>            
    </header>
    <div id="main-container" class="flex-container">
        <div id="caixa1">
            <section id="A">
            <form method="post" action="./controller/compra.php" class="form-container">
                <div class="form-group">
                    <input type="date" class="form-control" name="data_compra" id="data_compra" value="<?php echo date('Y-m-d'); ?>" placeholder="Data da Compra...">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="numero_da_compra" id="numero_da_compra" placeholder="Número da Compra...">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="fornecedor" id="fornecedor" placeholder="Fornecedor...">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="codigo_produto_compra" id="codigo_produto_compra" placeholder="Código do Produto...">
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" name="quantidade" id="quantidade" placeholder="Quantidade...">
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" name="valor" id="valor" placeholder="Valor...">
                </div>
                <div class="buttons-container">
                    <button type="submit" class="btn btn-primary form-control alinhaBtns">Comprar</button>
                    <input type="button" class="alinhaBtns" value="Ver Estoque" onclick="window.open('item.php','_self')">
                    <input type="button" class="alinhaBtns" value="Ver Saída" onclick="window.open('venda.php','_self')">
                    <input type="button" class="alinhaBtns" value="Voltar ao Menu" onclick="window.open('index.html','_self')">
                </div>
            </form>
            </section>
        </div>
        
        <div id="caixa2">
            <section>
                <div class="table-container">
                    <h2>Últimas compras</h2>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Número</th>
                                <th>Fornecedor</th>
                                <th>Código</th>
                                <th>Quantidade</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT * FROM compra";
                                $pesquisar = mysqli_query($Link, $sql);
                                while ($linha = $pesquisar->fetch_assoc()) {
                                    echo "
                                        <tr class='table-light'>
                                            <td>".$linha['data_compra']."</td>
                                            <td>".$linha['numero_da_compra']."</td>
                                            <td>".$linha['fornecedor']."</td>
                                            <td>".$linha['codigo_produto_compra']."</td>
                                            <td>".$linha['quantidade']."</td>
                                            <td>".$linha['valor']."</td>
                                        </tr>
                                    ";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
