<?php
  include 'processamento/usuario_dao.php';
  
  // 0 = cadastro não executado
  // 1 = cadastro realizado com sucesso
  // 2 = erro no cadastro
  $sucessoNoCadastro = 0;
  $mensagem = "";
  $icon = "";

  if (isset($_REQUEST["nome"])) {
    try {
      $nome = $_REQUEST["nome"];
      $email = $_REQUEST["email"];
      $senha = $_REQUEST["senhaHash"];
      $tipo = $_REQUEST["tipo"][0];

      $usuario = new Usuario(
        nome: $nome,
        email: $email,
        senha: $senha,
        tipo: $tipo
      );
  
      $usuario->persistir();
      $sucessoNoCadastro = 1;
      $mensagem = "Cadastro realizado com sucesso!";
      $icon = "success";

    } catch (Exception $ex) {
      $sucessoNoCadastro = 2;
      $mensagem = "Erro no cadastro: " . $ex->getMessage();
      $icon = "error";
    }
  }
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
    <form id="register-form" action="cadastro.php" method="post">

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

      <div class="link">Já tem uma conta? <a href="login.php">Entrar</a></div>
      <button type="submit">Cadastrar</button>
      <input type="hidden" id="senhaHash" name="senhaHash">
    </form>
  </div>
</body>

<script>

  monitorarSenha('senha', 'senhaHash');

  <?php if ($sucessoNoCadastro !== 0): ?>
     fire_swal(<?= json_encode($icon) ?>, <?= json_encode($mensagem) ?>);
  <?php endif; ?>

</script>
</html>
