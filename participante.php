<?php

$mensagem = '';
if (isset($_GET['cpf'])) {

  require 'banco.class.php';
  $banco = new Banco();

  $participante = $banco->selectWhere('Participante',[
    'cpf' => $_GET['cpf']
  ]);

  if (!$participante || count($participante) == 0) {
    unset($participante);
    $mensagem = "CPF não encontrado.";
  } else {

    $participante = $participante[0];

  }

}
#$participante = ['nome_participante' => 'jarbas', 'cpf' => '22222222222'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Seu QR-CODE - E-vento</title>
  <link rel="stylesheet" href="css.css">
</head>
<body>
  <div id="conteiner">
    <h1>E-VENTO IFMG</h1>

    <?php
    if (!isset($participante)) {
      ?>
    <form action="" method="get">
      <label>Digite seu CPF (só números):
        <input type="text" name="cpf" maxlength="11" inputmode="numeric" autofocus required>
      </label>
      <button type="submit">Ver QRCode</button>
      <p style="color: red"><?= $mensagem ?></p>
    </form>
    <?php
    } else {
    ?>
    <h2><?= $participante['nome_participante'] ?></h2>
    <p>CPF: <?= $participante['cpf'] ?></p>
    <div id="qrcode" style="width: 140px; margin: 0 auto;">
    </div>
    <p>Mostre esse QRCode para registrar sua presença nas atividades.</p>
    <p><a href="participante.php">Ver outro CPF</a></p>
    <script src="qrcode.min.js"></script>
    <script>
    var qrcode = new QRCode(document.querySelector('#qrcode'), {
      text: "<?= $participante['cpf'] ?>",
      width: 128,
      height: 128,
      colorDark : "#000000",
      colorLight : "#ffffff",
      correctLevel : QRCode.CorrectLevel.H
    });
    </script>
    <?php
    }
    ?>
  </div>
  <p id="rodape">Copyleft 2018 | Daniel Conrado - Larissa Maiello - Maria Eduarda Ribas - Matheus Vasconcelos | </p> 

</body>
</html>
