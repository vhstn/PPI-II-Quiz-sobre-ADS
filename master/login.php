<?php

  include_once 'processamento/session_manager.php';
  include_once 'processamento/usuario_dao.php';

  SessionManager::start();

  // 0 = login não executado
  // 1 = login realizado com sucesso
  // 2 = erro no login
  $sucesso = 0;
  $mensagem = "";
  $icon = "";

  if (isset($_REQUEST["email"])) {
    try {
      $email = $_REQUEST["email"];
      $senha = $_REQUEST["senhaHash"];
      
      $usuario = Usuario::buscaPorEmailESenha($email, $senha);

      if ($usuario == null) {
        throw new Exception("Usuário ou senha incorretos.");
      }

      SessionManager::setLoggedUser($usuario);

      $sucesso = 1;
      $mensagem = "Login realizado com sucesso. \nBem vindo(a), " . $usuario->nome . "!";
      $icon = "success";

    } catch (Exception $ex) {
      $sucesso = 2;
      $mensagem = "Erro no login: " . $ex->getMessage();
      $icon = "error";
    }
  }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="js/hashSenha.js"></script>
  <script src="js/swal.js"></script>
  <link rel="stylesheet" href="css/login.css">
  <meta charset="UTF-8" />
  <title>Login</title>
</head>
<body>
  <div class="container">
    <h2>Entrar na Conta</h2>
    <form id="login-form" action="login.php" method="post">

      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
      <label for="senha">Senha:</label>
      <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
      <div class="link">Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></div>
      <button type="submit">Entrar</button>
      <input type="hidden" id="senhaHash" name="senhaHash">
    </form>
  </div>
</body>

<script>

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
