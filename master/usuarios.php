<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Usuários Cadastrados</title>
  <style>
    body {
     margin: 0;
     font-family: 'Segoe UI', sans-serif;
     background: linear-gradient(to right, #667eea, #764ba2);
    }
    .pagina {
      display: flex;
      min-height: 100vh;
    }
    .container {
     flex: 1;
     padding: 2rem;
     background: white;
     margin: 2rem auto;
     border-radius: 12px;
     max-width: 900px;
     box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 12px;
      text-align: left;
    }
    th {
      background-color: #f0f0f0;
    }
    h2 {
      text-align: center;
    }
    .sidebar {
     width: 220px;
     background-color: #1e1e2f;
     color: white;
     padding: 2rem 1rem;
     display: flex;
     flex-direction: column;
   }

   /* Botões da sidebar */
   .nav-button {
     background: none;
     border: none;
     color: white;
     padding: 12px;
     text-align: left;
     width: 100%;
     font-size: 1rem;
     cursor: pointer;
     border-radius: 6px;
     transition: background 0.2s;
   }

   .nav-button:hover {
     background-color: #334;
   }
  </style>
</head>
<body>
  <div class="pagina">
 <div class="sidebar">
    <h2>Quiz ADS</h2>
    <button class="nav-button" onclick="location.href='quiz.php'">Quiz</button>
    <button class="nav-button" onclick="location.href='usuarios.php'">Usuários</button>
    <button class="nav-button" onclick="location.href='perguntas.php'">Perguntas</button>
    <button class="nav-button" onclick="location.href='logout.php'">Sair</button>
  </div>
  <div class="container">
    <h2>Usuários Cadastrados</h2>
    <table>
      <thead>
        <tr><th>Nome</th><th>Email</th><th>Ações</th></tr>
      </thead>
      <tbody id="users-table-body">
        <!-- Conteúdo gerado dinamicamente -->
      </tbody>
    </table>
    </div>
  </div>
</body>
</html>
