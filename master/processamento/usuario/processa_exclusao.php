<?php
    include '../session_manager.php';

    SessionManager::start();
    $loggedUser = SessionManager::requireAuthentication();
    try {
        Usuario::excluir($loggedUser->id);
        SessionManager::setFlashMessage([
            'icon' => 'success',
            'message' => 'Usuário excluído com sucesso!',
            'isLogoutRequest' => true
        ]);
        header('Location: ../../index.php');
    } catch (Exception $ex) {
        SessionManager::setFlashMessage([
            'icon' => 'error',
            'message' => 'Erro ao excluir o usuário: ' . $ex->getMessage()
        ]);

        header('Location: ../../index.php#atualizar');
    }
?>