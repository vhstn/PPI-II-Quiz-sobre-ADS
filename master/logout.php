<?php
    include_once 'processamento/session_manager.php';
    
    SessionManager::destroy();    
    header('Location: index.php#login');
?>