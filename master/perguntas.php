<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Perguntas do Quiz</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #667eea, #764ba2);
      padding: 2rem;
      color: #333;
    }
    .container {
      max-width: 1000px;
      margin: auto;
      background: white;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    }
    h2 {
      text-align: center;
      margin-bottom: 1.5rem;
    }
    button {
      background-color: #6699ff;
      color: white;
      padding: 10px 16px;
      border: none;
      border-radius: 6px;
      font-size: 1rem;
      cursor: pointer;
      margin-bottom: 1rem;
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

    /* Modal */
    .modal {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.6);
      justify-content: center;
      align-items: center;
      z-index: 10;
    }
    .modal.active {
      display: flex;
    }
    .modal-content {
      background: white;
      padding: 20px;
      border-radius: 12px;
      width: 90%;
      max-width: 500px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    }
    .modal-content h3 {
      margin-top: 0;
      margin-bottom: 1rem;
      text-align: center;
    }
    .modal-content form {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .modal-content input, .modal-content select {
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 1rem;
    }
    .modal-content .actions {
      display: flex;
      justify-content: space-between;
      gap: 10px;
      margin-top: 1rem;
    }
    .modal-content .actions button {
      flex: 1;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Perguntas do Quiz</h2>
    <button id="add-question-btn">Adicionar Nova Pergunta</button>

    <table>
      <thead>
        <tr>
          <th>Pergunta</th>
          <th>Opções</th>
          <th>Correta</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody id="questions-table-body">
        <!-- Conteúdo dinâmico -->
      </tbody>
    </table>
  </div>

  <!-- Modal -->
  <div id="question-modal" class="modal">
    <div class="modal-content">
      <h3>Nova Pergunta</h3>
      <form id="question-form">
        <input type="text" name="pergunta" placeholder="Digite a pergunta" required>
        <input type="text" name="opcao_a" placeholder="Opção A" required>
        <input type="text" name="opcao_b" placeholder="Opção B" required>
        <input type="text" name="opcao_c" placeholder="Opção C" required>
        <input type="text" name="opcao_d" placeholder="Opção D" required>
        <select name="correta" required>
          <option value="">Resposta correta</option>
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="C">C</option>
          <option value="D">D</option>
        </select>
        <div class="actions">
          <button type="submit">Salvar</button>
          <button type="button" id="close-modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const modal = document.getElementById('question-modal');
    const openBtn = document.getElementById('add-question-btn');
    const closeBtn = document.getElementById('close-modal');

    openBtn.onclick = () => modal.classList.add('active');
    closeBtn.onclick = () => modal.classList.remove('active');
    window.onclick = (e) => {
      if (e.target === modal) modal.classList.remove('active');
    };
  </script>
</body>
</html>
