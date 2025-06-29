<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <meta charset="UTF-8" />
  <title>Login</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      height: 100vh;
      background: linear-gradient(to right, #667eea, #764ba2);
      overflow: hidden;
    }
    body.swal2-shown {
      overflow: hidden !important;
      height: 100vh !important;
    }
    .container {
      position: fixed; 
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: white;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.2);
      max-width: 400px;
      width: 100%;
      transition: transform 0.3s ease;
    }
    h2 {
      text-align: center;
      margin-bottom: 1.5rem;
    }
    form {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    input {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
    }
    button {
      background-color: #6699ff;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 6px;
      font-size: 1rem;
      cursor: pointer;
    }
    .link {
      text-align: center;
      font-size: 0.9rem;
    }
    .link a {
      color: #3366ff;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Entrar na Conta</h2>
    <form id="login-form" onsubmit="login(event)">

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
    function login(evt){
      evt.preventDefault();
      const form = document.getElementById('login-form');
  
      if (!form.checkValidity()) {
        form.reportValidity();
        return;
      }

      const senhaInput = document.getElementById('senha').value;
      const senhaHash = document.getElementById('senhaHash');

      hashSenha(senhaInput).then(function(hashedSenha) {
        senhaHash.value = hashedSenha;
        validaLogin(hashedSenha);
      // }).catch(function(err) {
        // alert("Erro ao gerar o hash da senha.");
      });
    }

    async function hashSenha(senha) {
      const encoder = new TextEncoder();
      const data = encoder.encode(senha);
      const hashBuffer = await crypto.subtle.digest('SHA-256', data);
      const hashArray = Array.from(new Uint8Array(hashBuffer));
      const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
      return hashHex;
    }

    function validaLogin(hashedSenha){
      $.ajax({
        type: 'POST',
        url: 'login.php', // Aqui vai a parte do PHP que valida a senha
        data: {
          usuario: $('#usuario').val(),
          senha: $('#senha').val()
        },
        success: function(response) {
          if (response.success) {
            Swal.fire({
              icon: 'success',
              title: 'Cadastro realizado com sucesso!',
              confirmButtonText: 'OK'
            });
            window.location.href = 'perguntas.php';
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Login inválido',
              text: 'Usuário ou senha incorretos. Tente novamente.',
              confirmButtonText: 'OK'
            });
          }
        },
        error: function() {
          alert('Erro na comunicação com o servidor.');
        }
      });
    }
</script>
</html>
