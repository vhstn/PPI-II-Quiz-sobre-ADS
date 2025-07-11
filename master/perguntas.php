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
  <title>Perguntas do Quiz</title>
  <link rel="stylesheet" href="css/perguntas.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="pagina">
  <div class="sidebar">
    <h2 class="sidebar-h2">Quiz ADS</h2>
    <button class="nav-button" onclick="location.href='index.php#atualizar'">Minha conta</button>
    <button class="nav-button" onclick="location.href='index.php#quiz'">Quiz</button>
    <button class="nav-button" onclick="location.href='index.php#perguntas'">Perguntas</button>
    <button class="nav-button" onclick="location.href='logout.php'">Sair</button>
  </div>

  <div class="container">
    <h2>Perguntas do Quiz</h2>
    <button id="add-question-btn">Adicionar Nova Pergunta</button>
    <button onclick="document.getElementById('form-dump-inicial').submit()">Realizar dump inicial</button>
    <form id="form-dump-inicial" action="processamento/perguntas/processa_dump_inicial.php" method="post" >
    </form>
    
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
            <tr data-id="<?= $pergunta->getId() ?>">
              <td class="texto"><?= htmlspecialchars($pergunta->texto) ?></td>
              <td class="opcoes">
                <?php foreach ($pergunta->opcoes as $opcao): ?>
                  <div data-id="<?= $opcao->identificador ?>"><strong><?= $opcao->identificador ?>:</strong> <?= htmlspecialchars($opcao->texto) ?></div>
                <?php endforeach; ?>
              </td>
              <td class="correta"><?= $pergunta->opcaoCorreta()->identificador ?></td>
              <td>
                <button class="action-btn edit-btn">Editar</button>
                <form class="excluir-pergunta-form" action="processamento/perguntas/processa_exclusao.php" method="post">
                  <input type="hidden" name="idPergunta" id="idPergunta" value=<?= $pergunta->getId() ?>>  
                  <button type="submit" class="action-btn delete-btn">Excluir</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
    </div>
  </div>

  <!-- Modal adicionar/editar -->
  <div id="question-modal" class="modal">
    <div class="modal-content">
      <h3 id="modal-title">Nova Pergunta</h3>
      <form id="question-form" action="processamento/perguntas/processa_perguntas.php" method="post">
        <input type="hidden" name="id" id="id">
        <input type="text" name="pergunta" id="pergunta" placeholder="Digite a pergunta" required>
        <input type="text" name="opcao_A" id="opcao_A" placeholder="Opção A" required>
        <input type="text" name="opcao_B" id="opcao_B" placeholder="Opção B" required>
        <input type="text" name="opcao_C" id="opcao_C" placeholder="Opção C" required>
        <input type="text" name="opcao_D" id="opcao_D" placeholder="Opção D" required>
        <select name="correta" id="correta" required>
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
    var modal = document.getElementById('question-modal');
    var openBtn = document.getElementById('add-question-btn');
    var closeBtn = document.getElementById('close-modal');
    var modalTitle = document.getElementById('modal-title');

    openBtn.onclick = () => {
      modalTitle.textContent = 'Nova Pergunta';
      document.getElementById('question-form').reset();
      document.getElementById('id').value = '';
      modal.classList.add('active');
      document.getElementById('question-form').action = "processamento/perguntas/processa_perguntas.php";
    };

    closeBtn.onclick = () => modal.classList.remove('active');
    window.onclick = (e) => {
      if (e.target === modal) modal.classList.remove('active');
    };

    document.querySelectorAll('.edit-btn').forEach(btn => {
      btn.addEventListener('click', function () {
        const row = this.closest('tr');
        const id = row.dataset.id;
        const texto = row.querySelector('.texto').textContent;
        const opcoes = row.querySelectorAll('.opcoes div');
        const correta = row.querySelector('.correta').textContent.trim();

        modalTitle.textContent = 'Editar Pergunta';
        document.getElementById('id').value = id;
        document.getElementById('pergunta').value = texto;

        opcoes.forEach(div => {
          const letra = div.dataset.id;
          const valor = div.textContent.split(':')[1].trim();
          document.getElementById('opcao_' + letra).value = valor;
        });

        document.getElementById('correta').value = correta;
        modal.classList.add('active');

        document.getElementById('question-form').action = "processamento/perguntas/processa_atualizar.php";
      });
    });

    <?php if ($flashMessage): ?>
      Swal.fire({
        icon: <?= json_encode($flashMessage['icon'] ?? 'info') ?>,
        title: <?= json_encode($flashMessage['message'] ?? '') ?>,
        confirmButtonText: 'OK'
      });
    <?php endif; ?>

    document.querySelectorAll('.excluir-pergunta-form').forEach(form => {
      form.addEventListener('submit', function (e) {
        e.preventDefault(); 
      
        Swal.fire({
          title: 'Tem certeza?',
          text: "Você realmente deseja excluir esta pergunta?",
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
</body>
</html>
