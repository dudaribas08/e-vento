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

$mensagem = '';
$enviado = file_exists('participantes.csv');
if (isset($_FILES['csv'])) {
  if ($_FILES['csv']['error'] == UPLOAD_ERR_OK) {

		$pasta = '';
		$destino = $pasta . 'participantes.csv';
		if (!move_uploaded_file($_FILES['csv']['tmp_name'], $destino)) {
			$mensagem = "Ocorreu um erro.";
		}
    $enviado = true;

	} else {
		$mensagem = "Ocorreu um erro. Codigo:" . $_FILES['csv']['error'];
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>E-vento - presença</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css.css">
</head>
<body>
	<div id="voltarmenu">
		<a href="index.php">← Menu</a>
	</div>

	<div id="conteiner">
    <h2>Importar Participantes</h2>
    <form action="importar.php" method="POST" enctype="multipart/form-data">
      <label>
        Arquivo CSV (formato: id, nome, cpf, email)
        <input type="file" name="csv" accept="text/csv" autofocus required>
      </label>
      <div>
        <button type="submit">Carregar</button>
      </div>
      <p style="color: red"><?= $mensagem ?></p>
    </form>
    <?php
    if ($enviado) {
      ?>

      <p>Arquivo carregado</p>
      <p><button type="button" onclick="todos()">IMPORTAR TODOS</button></p>
      <table id="tabela" class="tabela">
      </table>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="csv.js"></script>
      <script>
      CSV.COLUMN_SEPARATOR=';';
      $.get("arquivo.php")
        .pipe( CSV.parse )
        .done( function(rows) {
          var table = $('#tabela');
          $.each(rows, function(rowIndex, r) {
              var row = $("<tr/>");
              $.each(r, function(colIndex, c) {
                  row.append($("<t"+(rowIndex == 0 ?  "h" : "d")+"/>").text(c));
              });
              if (rowIndex > 0)
                row.append($("<td><button class=\"btnimportar\" type=\"button\" onclick=\"importar(this)\">Importar</button></td>"));
              table.append(row);
          });
        });

        function importar(elem) {
          elem.disabled = true;
          elem.textContent = 'Importando...';

          var linha = elem.parentElement.parentElement;
          var dados = linha.querySelectorAll('td');
          var id = dados[0].textContent;
          var nome = dados[1].textContent;
          var cpf = dados[2].textContent;
          var email = dados[3].textContent;

          var form = new FormData();
          form.append('id', id);
          form.append('nome', nome);
          form.append('cpf', cpf);
          form.append('email', email);

          var xhr = new XMLHttpRequest();

          xhr.addEventListener('loadend', function(e) {
            if (!xhr.responseText || xhr.responseText == '0') {
              elem.textContent = 'Tentar de novo';
              elem.disabled = false;
            } else
              elem.textContent = 'Pronto!';
          });

          xhr.open('POST', 'importarparticipante.php');
          xhr.send(form);
        }

        function todos() {

          var botoes = document.querySelectorAll('.btnimportar');

          for (var i = 0; i < botoes.length; i++) {

            botoes[i].click();

          }

        }
      </script>


    <?php
    }
    ?>
  </div>
</body>
</html>
