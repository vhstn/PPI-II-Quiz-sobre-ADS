<?php
  include_once 'processamento/session_manager.php';
  include_once 'processamento/usuario_dao.php';
  include_once 'processamento/pergunta_dao.php';

  SessionManager::start();
  $loggedUser = SessionManager::requireAuthentication();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="css/perguntas.css">
  <title>Perguntas do Quiz</title>
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
