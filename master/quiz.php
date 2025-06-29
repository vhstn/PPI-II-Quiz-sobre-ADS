<?php
  include_once 'processamento/session_manager.php';
  include_once 'processamento/pergunta_dao.php';

  SessionManager::start();
  SessionManager::requireAuthentication();

  $perguntas = Pergunta::buscarTodas(scrambled: true);
  $flashMessage = SessionManager::getFlashMessage();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="css/quiz.css">
  <title>Responder Quiz</title>
</head>
<body>
  <div class="container">
    <h2>Quiz ADS</h2>
    <form id="quiz-form" action="processamento/quiz/processar_quiz.php" method="post">
      <input type="hidden" value="true" name="submitted" />
      <?php foreach ($perguntas as $pergunta): ?>
        <div class="question">
          <p><?= htmlspecialchars($pergunta->texto) ?></p>
          <?php foreach ($pergunta->opcoes as $opcao): ?>
            <label><input type="radio" name=<?= 'q' . $pergunta->id ?> value=<?= $opcao->identificador ?> required> <?= htmlspecialchars($opcao->texto) ?></label>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
      <button type="submit">Finalizar Quiz</button>
    </form>
  </div>
</body>
</html>

<script>
  <?php if ($flashMessage): ?>
    Swal.fire({
      icon: <?= json_encode($flashMessage['icon']) ?>,
      title: <?= json_encode($flashMessage['message']) ?>,
      confirmButtonText: 'OK'
    });
  <?php endif; ?>
  
</script>
