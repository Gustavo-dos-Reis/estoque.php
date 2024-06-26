<?php 
include_once "./Controller/conexao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendas</title>
    <link rel="stylesheet" href="./css/estoque.css">
</head>
<body>
    <div id="main-container" class="flex-container">
        <div id="caixa1">
            <section id="A">
                <form method="post" action="./Controller/venda.php" class="form-container">
                    <div class="form-group">
                        <label for="data_venda">Data da Venda</label>
                        <input type="date" class="form-control" name="data_venda" id="data_venda" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="numero_da_venda">Número da Venda</label>
                        <input type="text" class="form-control" name="numero_da_venda" id="numero_da_venda" placeholder="Número da Venda..." required>
                    </div>
                    <div class="form-group">
                        <label for="cliente">Cliente</label>
                        <input type="text" class="form-control" name="cliente" id="cliente" placeholder="Cliente..." required>
                    </div>
                    <div class="form-group">
                        <label for="produto_id">Produto</label>
                        <select class="form-control" name="produto_id" id="produto_id" required>
                            <option value="">Selecione o Produto...</option>
                            <?php
                                $sql = "SELECT * FROM item";
                                $result = mysqli_query($Link, $sql);
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantidade">Quantidade</label>
                        <input type="number" class="form-control" name="quantidade" id="quantidade" placeholder="Quantidade..." required>
                    </div>
                    <div class="form-group">
                        <label for="valor">Valor</label>
                        <input type="number" step="0.01" class="form-control" name="valor" id="valor" placeholder="Valor..." required>
                    </div>
                    <div class="buttons-container">
                        <button type="submit" class="alinhaBtns">Registrar Venda</button>
                       
                    </div>
                </form>
            </section>
        </div>
        
        <div id="caixa2">
            <section>
                <div class="table-container">
                    <h2>Vendas Registradas</h2>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Data da Venda</th>
                                <th>Número da Venda</th>
                                <th>Cliente</th>
                                <th>Produto</th>
                                <th>Quantidade da Venda</th>
                                <th>Valor da Venda</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT data_venda, numero_da_venda, cliente, produto, quantidade, valor FROM venda";
                                $result = mysqli_query($Link, $sql);
                                while ($row = mysqli_fetch_assoc($result)){
                                    echo "
                                        <tr class='table-light'>
                                            <td>{$row['data_venda']}</td>
                                            <td>{$row['numero_da_venda']}</td>
                                            <td>{$row['cliente']}</td>
                                            <td>{$row['produto']}</td>
                                            <td>{$row['quantidade']}</td>
                                            <td>{$row['valor']}</td>
                                        </tr>
                                    ";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="buttons-container-btns">
                    <input type="button" class="Btns" value="Estoque" onclick="window.open('item.php','_self')">  
                    <input type="button" class="Btns" value="Compras" onclick="window.open('compra.php','_self')">
                    <input type="button" class="Btns" value="Menu" onclick="window.open('index.html','_self')">
                </div>
            </section>
        </div>
    </div>
</body>
</html>
