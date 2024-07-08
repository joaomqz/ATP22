<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Devil's Garage - Cadastro</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='./estilos/main.css'>
    <script src='./script/form.js' defer></script>
</head>

<body>
    <!--Cabeçalho-->
    <header class="head">
        <main>
            <div class="header1">
                <div class="logo">
                    <img src="./img/logo2.png" width="144px">
                </div>
            </div>
        </main>
    </header>

    <!--Menu Links-->
    <main class="menu-urls">
        <div class="menu">
            <ul>
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li>
                    <a href="about.html">Sobre</a>
                </li>
                <li>
                    <a href="form.html">Login</a>
                </li>
            </ul>
        </div>
    </main>

    <div class="form-container">
        <h2>Cadastro de Novo Usuário</h2>
        <form action="processarCadastro.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
            
            <input type="submit" id="submit" name="submit" value="Cadastrar">
        </form>
    </div>

    <div class="form-container">
        <h2>Login</h2>
        <form action="logar.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
            
            <input type="submit" id="submit" name="submit" value="Login">
        </form>
    </div>

    <footer class="footer">
        <h3>© 2024 Criado por João Henrique Marquez</h3>
    </footer>
</body>

</html>
