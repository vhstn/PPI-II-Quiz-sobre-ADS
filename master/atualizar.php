<?php
    include_once 'processamento/session_manager.php';
    include_once 'processamento/usuario_dao.php';

    SessionManager::start();
    
    $senhaDefault = "********";
    $loggedUser = SessionManager::requireAuthentication();
    $pontuacoes = $loggedUser->buscarPontuacoes();

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
  <link rel="stylesheet" href="css/atualizar.css">
</head>
<body>
  <div class="pagina">
  <div class="sidebar">
    <h2 class="sidebar-h2">Quiz ADS</h2>
    <button class="nav-button" onclick="location.href='atualizar.php'">Minha conta</button>
    <button class="nav-button" onclick="location.href='quiz.php'">Quiz</button>
    <button class="nav-button" onclick="location.href='perguntas.php'">Perguntas</button>
    <button class="nav-button" onclick="location.href='logout.php'">Sair</button>
  </div>
  <div class="main-content">
  
  <div class="container">
    <h2>Minhas informações</h2>
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

      <button type="submit">Atualizar informações</button>
      <input type="hidden" id="senhaHash" name="senhaHash">
    </form>
    <form id="excluir-conta-form" action="processamento/usuario/processa_exclusao.php" method="post">
      <button type="submit">Excluir conta</button>
    </form>
  </div>
            <!-- Card 2: Pontuações -->
  <div class="container">
    <h2>Minhas Pontuações</h2>
    <?php if (empty($pontuacoes)): ?>
      <p>Você ainda não respondeu o quiz!</p>
    <?php else: ?>
    <table class="score-table">
      <thead>
        <tr>
          <th>Data</th>
          <th>Acertos</th>
          <th>Questões</th>
          <th>Média</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($pontuacoes as $pontuacao): ?>
        <tr>
          <td><?= $pontuacao->data ?></td>
          <td><?= $pontuacao->qtdAcertos ?></td>
          <td><?= $pontuacao->qtdPerguntas ?></td>
          <td><?= $pontuacao->percentual ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
  </div>
</div>
</body>

<script>

  monitorarSenha('senha', 'senhaHash');

  <?php if ($flashMessage): ?>
    Swal.fire({
      icon: <?= json_encode($flashMessage['icon']) ?>,
      title: <?= json_encode($flashMessage['message']) ?>,
      confirmButtonText: 'OK'
    });
  <?php endif; ?>

      document.querySelectorAll('#excluir-conta-form').forEach(form => {
      form.addEventListener('submit', function (e) {
        e.preventDefault(); 
      
        Swal.fire({
          title: 'Tem certeza?',
          text: "Você realmente deseja excluir sua? Todas as suas informações serão perdidas.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Sim, excluir!',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });

</script>