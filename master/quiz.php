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
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #667eea, #764ba2);
      height: 100vh;
      overflow: hidden;
    }

    .pagina {
      display: flex;
      height: 100vh;
      width: 100vw;
    }
    .container {
     flex: 1;
     padding: 2rem;
     background: white;
     margin: 2rem auto;
     border-radius: 12px;
     max-width: 900px;
     box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
     overflow-y: auto;
    }

    .question {
      margin-bottom: 2rem;
    }
    .question p {
      font-weight: bold;
      margin-bottom: 0.5rem;
    }
    .question label {
      display: block;
      margin: 4px 0;
    }
    button {
      background-color: #6699ff;
      color: white;
      padding: 12px;
      font-size: 1rem;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      display: block;
      margin: 0 auto;
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
    h2 {
      text-align: center;
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
    <button class="nav-button" onclick="location.href='index.php#atualizar'">Minha conta</button>
    <button class="nav-button" onclick="location.href='index.php#quiz'">Quiz</button>
    <button class="nav-button" onclick="location.href='index.php#perguntas'">Perguntas</button>
    <button class="nav-button" onclick="location.href='logout.php'">Sair</button>
  </div>
  <div class="container">
    <h2>Quiz ADS</h2>
    <?php if (empty($perguntas)): ?>
      <h3>Não há perguntas cadastradas! Contate o administrador de sistema.</h3>
    <?php else: ?>
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
    <?php endif; ?>
  </div>
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
