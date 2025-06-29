<?php
    include '../session_manager.php';
    include '../pergunta_dao.php';

    SessionManager::start();
    SessionManager::requireAdminUser();

    if (isset($_REQUEST['idPergunta'])) {
        try {
            Pergunta::excluir($_REQUEST['idPergunta']);

            SessionManager::setFlashMessage([
                'icon' => 'success',
                'message' => 'Pergunta excluída com sucesso!'
            ]);
        } catch (Exception $ex) {
            SessionManager::setFlashMessage([
                'icon' => 'error',
                'message' => 'Erro ao excluir a pergunta: ' . $ex->getMessage()
            ]);
        }
    }

    header('Location: ../../index.php#perguntas');
?>