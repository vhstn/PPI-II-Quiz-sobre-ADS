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
      padding: 2rem;
      color: #333;
    }
    .container {
      background: white;
      padding: 2rem;
      border-radius: 12px;
      max-width: 900px;
      margin: auto;
      box-shadow: 0 0 20px rgba(0,0,0,0.2);
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
  </style>
</head>
<body>
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
</body>
</html>
