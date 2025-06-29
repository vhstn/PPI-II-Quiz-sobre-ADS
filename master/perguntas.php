<?php
  include_once 'processamento/session_manager.php';
  include_once 'processamento/usuario_dao.php';
  include_once 'processamento/pergunta_dao.php';

  SessionManager::start();
  SessionManager::requireAdminUser();

  $flashMessage = SessionManager::getFlashMessage();
  $perguntas = Pergunta::buscarTodas();
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

    <?php if (empty($perguntas)): ?>
      <h3>Sem perguntas cadastradas no sistema.</h3>
    <?php else: ?>
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
          <?php foreach ($perguntas as $pergunta): ?>
            <tr>
              <td><?= htmlspecialchars($pergunta->texto) ?></td>
              <td>
                <ul class="opcoes-lista">
                  <?php foreach ($pergunta->opcoes as $opcao): ?>
                    <li>
                      <strong><?= $opcao->identificador . ':' ?></strong>
                      <?= htmlspecialchars($opcao->texto) ?>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </td>
              <td><?= $pergunta->opcaoCorreta()->identificador ?></td>
              <td>
                <button class="action-btn edit-btn">Editar</button>
                <button class="action-btn delete-btn">Excluir</button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

  <!-- Modal -->
  <div id="question-modal" class="modal">
    <div class="modal-content">
      <h3>Nova Pergunta</h3>
      <form id="question-form" action="processamento/processa_perguntas.php" method="post">
        <input type="text" name="pergunta" placeholder="Digite a pergunta" required>
        <input type="text" name="opcao_A" placeholder="Opção A" required>
        <input type="text" name="opcao_B" placeholder="Opção B" required>
        <input type="text" name="opcao_C" placeholder="Opção C" required>
        <input type="text" name="opcao_D" placeholder="Opção D" required>
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

    <?php if ($flashMessage): ?>
      Swal.fire({
        icon: <?= json_encode($flashMessage['icon']) ?>,
        title: <?= json_encode($flashMessage['message']) ?>,
        confirmButtonText: 'OK'
      });
  <?php endif; ?>
  </script>
</body>
</html>
