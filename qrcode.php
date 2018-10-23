<?php
require_once 'funcoes.php';
require_once 'banco.class.php';
require_once 'login.class.php';

session_start();

$banco = new Banco();
$login = new Login($banco);

if (!$login->usuarioEstaLogado()) {
	redirecionarPara('login.php');
}

$usuario = $login->getUsuario();
$id = $_GET['id'];
$atividade = $banco->selectWhere('Atividade' , [
	'id_atividade'=>$id
	])[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Registro de Presença</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link rel="stylesheet" href="css.css">
</head>
<body>
	<div id="conteiner">
		<h1> <?=$atividade['nome_atividade']?> </h1>
		<div id="camera">
			<video id="preview"></video>
		</div>
	</div>
	<form id="dados" action="presenca.php" method="post">
		<label for="cpf_participante">CPF:</label>
		<input type="text" name="cpf_participante" id="cpf_participante" maxlength="11" inputmode="numeric" autofocus>
		<input type="hidden" name="id_atividade" value="<?= $id ?>">
	</form>
	<script type="text/javascript" src="instascan.min.js"></script>
	<script type="text/javascript">
      let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
      scanner.addListener('scan', function (content) {
        var cpf_participante = content;
        enviarDados(cpf_participante);
      });
      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
					var ci = 0;

					if (cameras.length > 1)
						ci = parseInt(window.prompt('Tem ' + cameras.length + ' cameras. Qual abrir?'));

          scanner.start(cameras[ci]);
        } else {
          console.error('No cameras found.');
        }
      }).catch(function (e) {
        console.error(e);
      });

      function enviarDados(cpf_participante) {
      	document.querySelector('#cpf_participante').value = cpf_participante;
      	document.querySelector('#dados').submit();
      }
    </script>
</body>
</html>
