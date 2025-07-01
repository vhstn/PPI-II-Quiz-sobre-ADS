<?php
    include_once 'processamento/session_manager.php';
    
    SessionManager::start();

    SessionManager::setFlashMessage([
        'icon' => 'success',
        'message' => 'Logout efetuado com sucesso!',
        'isLogoutRequest' => true
    ]);
      
    header('Location: index.php#login');
?>