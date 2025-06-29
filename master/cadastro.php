<?php
  include_once 'processamento/session_manager.php';
  SessionManager::start();

  $flashMessage = SessionManager::getFlashMessage();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta charset="UTF-8" />
  <title>Cadastro</title>
  <script src="js/hashSenha.js"></script>
  <script src="js/swal.js"></script>
  <link rel="stylesheet" href="css/cadastro.css">
</head>
<body>
  <div class="container">
    <h2>Crie sua Conta</h2>
    <form id="register-form" action="processamento/processa_cadastro.php" method="post">

      <label for="nome">Nome:</label>
      <input type="text" id="nome" name="nome" placeholder="Digite seu nome" required>

      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>

      <label for="senha">Senha:</label>
      <input type="password" id="senha" name="senha" placeholder="Crie uma senha" required>

      <label for="tipo">Tipo de usuário:</label>
      <select id="tipo" name="tipo" required>
        <option value="usuario" selected>Usuário</option>
        <option value="admin">Administrador</option>
      </select>

      <div class="link">Já tem uma conta? <a href="#login">Entrar</a></div>
      <button type="submit">Cadastrar</button>
      <input type="hidden" id="senhaHash" name="senhaHash">
    </form>
  </div>
</body>

<script>

  monitorarSenha('senha', 'senhaHash');

  <?php if ($flashMessage): ?>
     fire_swal(
      <?= json_encode($flashMessage['icon']) ?>, 
      <?= json_encode($flashMessage['message']) ?>
    );
  <?php endif; ?>

</script>
</html>
