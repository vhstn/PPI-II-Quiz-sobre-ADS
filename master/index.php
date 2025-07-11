<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/hashSenha.js"></script>
  <script src="js/swal.js"></script>
  <meta charset="UTF-8" />
  <title>Quiz de ADS</title>
</head>
<style>
  body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(to right, #667eea, #764ba2);
    overflow-x: hidden;
  }

#conteudo-principal {
  width: 100%;
  min-height: 100vh;
}
</style>

</style>
<body>
    <div id="conteudo-principal"></div>
</body>

<script>
  function carregarPaginaHash() {
    const rota = window.location.hash || '#login'; 
    let pagina = '';
    switch (rota) {
      case '#login':
        pagina = 'login.php';
        break;
      case '#perguntas':
        pagina = 'perguntas.php';
        break;
      case '#quiz':
        pagina = 'quiz.php';
        break;
      case '#atualizar':
        pagina = 'atualizar.php';
        break;
      default:
        pagina = 'cadastro.php';
    }
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
      }
    });
  }

  window.addEventListener('hashchange', carregarPaginaHash);

  $(document).ready(carregarPaginaHash);

</script>
</html>
