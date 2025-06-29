<?php
    include_once 'processamento/session_manager.php';
    include_once 'processamento/usuario_dao.php';

    SessionManager::start();
    
    $senhaDefault = "********";
    $loggedUser = SessionManager::requireAuthentication();

    $uSelected = ($loggedUser->tipo) == "U" ? "selected" : "";
    $aSelected = ($loggedUser->tipo) == "A" ? "selected" : "";

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
    <h2><?= $loggedUser->nome ?>, atualize seu cadastro</h2>
    <form id="register-form" action="processamento/usuario/processa_atualizar.php" method="post">

      <label for="nome">Nome:</label>
      <input type="text" id="nome" name="nome" placeholder="Digite seu nome" value=<?= $loggedUser->nome ?> required>

      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" placeholder="Digite seu e-mail" value=<?= $loggedUser->email ?> required>

      <label for="senha">Senha:</label>
      <input type="password" id="senha" name="senha" placeholder="Crie uma senha" value=<?= $senhaDefault ?> required>

      <label for="tipo">Tipo de usuário:</label>
      <select id="tipo" name="tipo" required>
        <option value="U" <?= $uSelected ?>>Usuário</option>
        <option value="A" <?= $aSelected ?>>Administrador</option>
      </select>

      <button type="submit">Atualizar</button>
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