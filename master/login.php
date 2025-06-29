<?php
  include_once 'processamento/session_manager.php';
  SessionManager::start();

  $flashMessage = SessionManager::getFlashMessage();
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
    <form id="login-form" action="processamento/processa_login.php" method="post">

      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
      <label for="senha">Senha:</label>
      <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
      <div class="link">Não tem uma conta? <a href="#cadastro">Cadastre-se</a></div>
      <button type="submit">Entrar</button>
      <input type="hidden" id="senhaHash" name="senhaHash">
    </form>
  </div>
</body>

<script>

  monitorarSenha('senha', 'senhaHash');

  <?php if ($flashMessage): ?>
    Swal.fire({
      icon: <?= json_encode($flashMessage['icon']) ?>,
      title: <?= json_encode($flashMessage['message']) ?>,
      confirmButtonText: 'OK'

    }).then((resultado) => {
      if (<?= json_encode($flashMessage['issuccess'] ?? false) ?>) {
        window.location.href = "index.php#quiz";
      }

    })
  <?php endif; ?>
  
</script>
</html>
