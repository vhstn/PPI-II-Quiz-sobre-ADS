<?php
    include '../session_manager.php';
    include '../pergunta_dao.php';

    SessionManager::start();
    $loggedUser =  SessionManager::requireAuthentication();

    if (isset($_REQUEST["submitted"])) {
        try {
            $perguntas = Pergunta::buscarTodas();
            $pontuacao = 0;
            $qtdPerguntas = count($perguntas);

            foreach ($perguntas as $pergunta) {
                $resposta = $_REQUEST['q' . $pergunta->getId()];
                if ($resposta == $pergunta->opcaoCorreta()->identificador) {
                    $pontuacao++;
                }
            }

            SessionManager::setFlashMessage([
                'icon' => 'info',
                'message' => 'Quiz concluído! Sua pontuação foi de ' . $pontuacao . '/' . $qtdPerguntas
            ]);
        }
        catch (Exception $ex) {
            SessionManager::setFlashMessage([
                'icon' => 'error',
                'message' => 'Houve um erro ao calcular sua pontuação: ' . $ex->getMessage()
            ]);
        }
    }

    header('Location: ../../index.php#quiz');
?>