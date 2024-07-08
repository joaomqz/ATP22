<?php
require 'verifica.php';

if (isset($_SESSION['idUser']) && !empty($_SESSION['idUser'])):
    $idUser = $_SESSION['idUser'];

    // Conexão com o banco de dados
    $conn = new mysqli('localhost', 'root', '', 'atp2');

    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Consulta para obter os pedidos do usuário
    $sql = "SELECT c.id_usuario, c.item, c.valor
            FROM compras c 
            WHERE c.id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $idUser);
    $stmt->execute();
    $result = $stmt->get_result();

    //$compras = [];
    while ($row = $result->fetch_assoc()) {
        //$compras[$row['id_usuario']]['data_compra'] = $row['data_compra'];
        $compras[$row['id_usuario']]['item'][] = ['nome' => $row['item'], 'valor' => $row['valor']];
    }

    $stmt->close();
    $conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Meus Pedidos - Devil's Garage</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='./estilos/main.css'>
    <script src='./script/form.js'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .order-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .order-item {
            margin: 10px 0;
        }

        .order-total {
            font-weight: bold;
            font-size: 20px;
            margin-top: 20px;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Devil's Garage</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="criarCadastro.php">Cadastro</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="customizacao.php">Customização</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pedidos.php">Meus Pedidos</a>
                </li>
            </ul>
            <div class="form2.0">
                <label class="mr-"><?php echo $_SESSION["idUser"]; ?></label>
                <a href="logout.php">SAIR</a>
            </div>
        </div>
    </div>
</nav>

<main class="menu-urls">
    <div class="order-container">
        
        <?php if (!empty($compras)): ?>
            <?php foreach ($compras as $idCompra => $compra): ?>
                <div class="order-item">
                   <h4>Pedidos</h4>
                    <ul class="list-group">
                        <?php $total = 0; ?>
                        <?php foreach ($compra['item'] as $item): ?>
                            <li class="list-group-item">
                                <?php echo $item['nome']; ?> - R$<?php echo number_format($item['valor'], 2, ',', '.'); ?>
                                <?php $total += $item['valor']; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="order-total">Total do pedido: R$<?php echo number_format($total, 2, ',', '.'); ?></div>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Você ainda não fez nenhum pedido.</p>
        <?php endif; ?>
    </div>
   
    <div>

    <button type="button" class="buttonred" onclick="excluir()">Cancelar Pedido</button>

    </div>
</main>



  


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>

<?php
else: header("Location: criarCadastro.php"); endif;
?>
