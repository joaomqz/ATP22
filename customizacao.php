<?php
require 'verifica.php';

if (isset($_SESSION['idUser']) && !empty($_SESSION['idUser'])):

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Devil's Garage</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='./estilos/main.css'>
    <script src='./script/form.js'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .form-container, .cart-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .custom-item {
            margin: 10px 0;
        }

        .total-cost {
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
                    <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Cadastro</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Customização</a>
                </li>
            </ul>
            <div class="form2.0">
                <label class="mr-"><?php echo $nomeUser; ?></label>
                <a href="logout.php">SAIR</a>
            </div>
        </div>
    </div>
</nav>

<main class="menu-urls">
    <div class="form-container">
        <form id="customForm">
            <div class="mb-3">
                <label for="moto" class="form-label">Escolha sua Harley:</label>
                <select class="form-select" id="moto">
                    <option value="0">Selecione uma moto</option>
                    <option value="10000">Harley Davidson ULTRA LIMITED</option>
                    <option value="15000">Harley Davidson GLIDE </option>
                    <option value="20000">Harley Davidson ROAD GLIDE</option>
                    <option value="25000">Harley Davidson STREET GLIDE </option>
                    <option value="30000">Harley Davidson XL 1200 </option>
                </select>
            </div>

            <div class="custom-item">
                <input type="checkbox" id="banco" value="2000">
                <label for="banco">Banco</label>
            </div>
            <div class="custom-item">
                <input type="checkbox" id="quadro" value="3000">
                <label for="quadro">Quadro</label>
            </div>
            <div class="custom-item">
                <input type="checkbox" id="aro" value="1500">
                <label for="aro">Aro</label>
            </div>
            <div class="custom-item">
                <input type="checkbox" id="guidao" value="1000">
                <label for="guidao">Guidão</label>
            </div>
            <div class="custom-item">
                <input type="checkbox" id="motor" value="5000">
                <label for="motor">Motor</label>
            </div>

            <div class="total-cost" id="totalCost">Valor total: R$0,00</div>

            <div class="button-container">
                <button type="button" class="btn btn-success btn-custom" onclick="comprar()">Adicionar ao carrinho</button>
                
            </div>
        </form>
    </div>

    <div class="cart-container">
        <h3>Seu Carrinho</h3>
        <ul id="cartItems" class="list-group">
            <!-- Items will be dynamically added here -->
        </ul>
        <div class="total-cost" id="cartTotalCost">Valor total do carrinho: R$0,00</div>
        <button type="button" class="btn btn-primary" onclick="finalizarCompra()">Finalizar Compra</button>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const motoSelect = document.getElementById('moto');
    const customItems = document.querySelectorAll('.custom-item input');
    const totalCostElement = document.getElementById('totalCost');
    const cartItemsElement = document.getElementById('cartItems');
    const cartTotalCostElement = document.getElementById('cartTotalCost');
    let cart = [];

    function updateTotalCost() {
        let totalCost = parseFloat(motoSelect.value) || 0;

        customItems.forEach(item => {
            if (item.checked) {
                totalCost += parseFloat(item.value);
            }
        });

        totalCostElement.textContent = 'Valor total: R$' + totalCost.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function updateCartTotalCost() {
        let cartTotalCost = 0;

        cart.forEach(item => {
            cartTotalCost += item.value;
        });

        cartTotalCostElement.textContent = 'Valor total do carrinho: R$' + cartTotalCost.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function comprar() {
        const items = [];
        let motoValue = parseFloat(motoSelect.value) || 0;
        if (motoValue > 0) {
            items.push({ name: motoSelect.options[motoSelect.selectedIndex].text, value: motoValue });
        }
        customItems.forEach(item => {
            if (item.checked) {
                items.push({ name: item.nextElementSibling.textContent, value: parseFloat(item.value) });
            }
        });

        if (items.length > 0) {
            items.forEach(item => {
                cart.push(item);
                const li = document.createElement('li');
                li.textContent = item.name + ' - R$' + item.value.toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                li.classList.add('list-group-item');
                cartItemsElement.appendChild(li);
            });
            updateCartTotalCost();
            alert("Itens adicionados ao carrinho!");
        } else {
            alert("Selecione pelo menos uma moto ou item para adicionar ao carrinho.");
        }
    }

    function excluir() {
        cart = [];
        while (cartItemsElement.firstChild) {
            cartItemsElement.removeChild(cartItemsElement.firstChild);
        }
        updateCartTotalCost();
        alert("Carrinho esvaziado com sucesso!");
    }

    function finalizarCompra() {
        if (cart.length > 0) {
            fetch('registrarCompra.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ items: cart })
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    alert("Compra realizada com sucesso! Valor total: " + cartTotalCostElement.textContent);
                    excluir(); // Esvaziar o carrinho após a compra
                } else {
                    alert("Falha na compra: " + data.message);
                }
            });
        } else {
            alert("O carrinho está vazio.");
        }
    }

    motoSelect.addEventListener('change', updateTotalCost);
    customItems.forEach(item => {
        item.addEventListener('change', updateTotalCost);
    });

    window.comprar = comprar;
    window.excluir = excluir;
    window.finalizarCompra = finalizarCompra;
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>

<?php
else: header("Location: criarCadastro.php"); endif;
?>
