<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta charset="UTF-8" />
  <title>Cadastro</title>
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
      position: fixed; /* <- muda de absolute para fixed */
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
    input, select {
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
    <h2>Crie sua Conta</h2>
    <form id="register-form" onsubmit="cadastra(event)">

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
  function cadastra(evt) {
    evt.preventDefault();

    const form = document.getElementById('register-form');
  
    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }

    var senha = document.getElementById('senha').value.trim();

    hashSenha(senha).then(function(hashedSenha) {
      document.getElementById('senhaHash').value = hashedSenha;
      Swal.fire({
        icon: 'success',
        title: 'Cadastro realizado com sucesso!',
        confirmButtonText: 'OK'
      });
    }).catch(function(err) {
      alert("Erro ao gerar hash da senha.");
    });
  }

  async function hashSenha(senha) {
    const encoder = new TextEncoder();
    const data = encoder.encode(senha);
    const hashBuffer = await crypto.subtle.digest('SHA-256', data);
    const hashArray = Array.from(new Uint8Array(hashBuffer)); 
    const hashHex = hashArray.map(byte => byte.toString(16).padStart(2, '0')).join(''); 
    return hashHex;
  }
</script>
</html>
