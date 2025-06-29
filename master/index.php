<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta charset="UTF-8" />
  <title>Quiz de ADS</title>
  <script src="js/hashSenha.js"></script>
  <script src="js/swal.js"></script>
  <link rel="stylesheet" href="css/cadastro.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div id="conteudo-principal"></div>
</body>

<script>
  function carregarPagina(pagina) {
    $.ajax({
      url: pagina,
      method: 'GET',
      success: function (data) {
        $('#conteudo-principal').html(data);
      },
      error: function () {
        Swal.fire({
          icon: 'error',
          title: 'Erro',
          text: 'Não foi possível carregar a página.'
        });
        carregarPagina('login.php');
      }
    });
  }
  
  $(document).ready(function () {
    carregarPagina('login.php');
  });

  monitorarSenha('senha', 'senhaHash');

  <?php if ($sucesso !== 0): ?>
    Swal.fire({
      icon: <?= json_encode($icon) ?>,
      title: <?= json_encode($mensagem) ?>,
      confirmButtonText: 'OK'

    }).then((resultado) => {
      if (<?= $sucesso ?> === 1) {
        window.location.href = "quiz.php";
      }
      
    })
  <?php endif; ?>
</script>
</html>
