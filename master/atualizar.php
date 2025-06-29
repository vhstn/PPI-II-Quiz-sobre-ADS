<?php

    $senhaDefault = "********";
    include_once 'processamento/session_manager.php';
    include_once 'processamento/usuario_dao.php';

    SessionManager::start();
    $loggedUser = SessionManager::getLoggedUser();

    if ($loggedUser == null) {
        throw new Exception("Você precisa estar logado para acessar esta página.");
    }

    // 0 = atualização não executada
    // 1 = atualização realizada com sucesso
    // 2 = erro na atualização
    $sucesso = 0;
    $mensagem = "";
    $icon = "";

    if (isset($_REQUEST["nome"])) {
        try {
            $nome = $_REQUEST["nome"];
            $email = $_REQUEST["email"];
            $senha = $_REQUEST["senha"];
            $hash = $_REQUEST["senhaHash"];
            $tipo = $_REQUEST["tipo"][0];
      
            $loggedUser->nome = $nome;
            $loggedUser->email = $email;
            if ($senha != $senhaDefault) {
                $loggedUser->senha = $hash;
            }
            $loggedUser->tipo = $tipo;
    
            $loggedUser->atualizar();
            SessionManager::setLoggedUser($loggedUser);

            $sucesso = 1;
            $mensagem = $loggedUser->nome . ", seus dados foram atualizados com sucesso!";
            $icon = "success";

        } catch (Exception $ex) {
            $sucesso = 2;
            $mensagem = "Erro ao atualizar os dados: " . e->getMessage();
            $icon = "error";
        }
    }

    $uSelected = ($loggedUser->tipo) == "U" ? "selected" : "";
    $aSelected = ($loggedUser->tipo) == "A" ? "selected" : "";
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
    <form id="register-form" action="atualizar.php" method="post">

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