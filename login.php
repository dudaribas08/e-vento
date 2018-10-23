<?php

require_once 'funcoes.php';
require_once 'banco.class.php';
require_once 'login.class.php';

session_start();

$banco = new Banco();
$login = new Login($banco);

if ($login->usuarioEstaLogado()) {
	redirecionarPara('index.php');
}

$mensagem = '';
if (isset($_POST['btnentrar'])) { // o formulário foi submetido. Tentar logar

	if ($login->fazerLogin($_POST['login'], $_POST['senha'])) {
		redirecionarPara('index.php');
	} else {
		$mensagem = "Usuário/senha não confere.";
	}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login - e-vento</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css.css">
</head>
<body>
	<header>
		<h1>E-vento</h1>
	</header>
	<main class="bloco-central">

		<form class="form-empilhado bloco-pequeno" action="login.php" method="post">
			<p class="mensagem"><?= $mensagem ?></p>
			<label for="ilogin">Login</label>
			<input id="ilogin" type="text" name="login">
			<label for="isenha">Senha</label>
			<input type="password" name="senha" id="isenha">
			<button type="submit" name="btnentrar">Entrar</button>
		</form>

	</main>
</body>
</html>