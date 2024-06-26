<?php include_once "./Controller/conexao.php"; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compras</title>
    <link rel="stylesheet" href="./css/estoque.css">
</head>
<body>
    <div id="main-container" class="flex-container">
        <div id="caixa1">
            <section id="A">
            <form method="post" action="./controller/compra.php" class="form-container">
                <div class="form-group">
                    <label for="data_compra">Data da Compra</label>
                    <input type="date" class="form-control" name="data_compra" id="data_compra" value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="form-group">
                    <label for="numero_da_compra">Numero da Compra</label>
                    <input type="text" class="form-control" name="numero_da_compra" id="numero_da_compra" placeholder="Número da Compra..." required>
                </div>
                <div class="form-group">
                    <label for="fornecedor">Fornecedor</label>
                    <input type="text" class="form-control" name="fornecedor" id="fornecedor" placeholder="Fornecedor..." required>
                </div>
                <div class="form-group">
                    <label for="codigo_produto_compra">Código da Compra</label>
                    <select class="form-control" name="codigo_produto_compra" id="codigo_produto_compra" required>
                        <option value="">Selecione o Código do Produto...</option>
                        <?php
                            $sql = "SELECT codigo_produto, nome FROM item";
                            $result = mysqli_query($Link, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['codigo_produto']}'>{$row['codigo_produto']} - {$row['nome']}</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantidade">Quantidade da Compra</label>
                    <input type="number" class="form-control" name="quantidade" id="quantidade" placeholder="Quantidade..." required>
                </div>
                <div class="form-group">
                    <label for="valor">Valor da Compra</label>
                    <input type="number" class="form-control" name="valor" id="valor" placeholder="Valor..." step="0.01" required>
                </div>
                <div class="buttons-container">
                    <button type="submit" class="alinhaBtns">Comprar</button>
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
                <div class="buttons-container-btns">
                    <input type="button" class="Btns" value="Estoque" onclick="window.open('item.php','_self')">
                    <input type="button" class="Btns" value="Vendas" onclick="window.open('venda.php','_self')">
                    <input type="button" class="Btns" value="Menu" onclick="window.open('index.html','_self')">
                </div>
            </section>
        </div>
    </div>
</body>
</html>
