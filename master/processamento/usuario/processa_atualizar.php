<?php
    $senhaDefault = "********";
    include_once '../session_manager.php';
    include_once '../usuario_dao.php';

    SessionManager::start();
    $loggedUser = SessionManager::getLoggedUser();

    $mensagem = "";
    $icon = "";

    if (isset($_REQUEST["nome"])) {
        try {
            $nome = $_REQUEST["nome"];
            $email = $_REQUEST["email"];
            $senha = $_REQUEST["senha"];
            $hash = $_REQUEST["senhaHash"];
            $tipo = $_REQUEST["tipo"][0];
      
            $loggedUser->nome = $nome;
            $loggedUser->email = $email;
            if ($senha !== $senhaDefault) {
                $loggedUser->senha = $hash;
            }
            $loggedUser->tipo = $tipo;
    
            $loggedUser->atualizar();
            SessionManager::setLoggedUser($loggedUser);

            SessionManager::setFlashMessage([
                'icon' => 'success',
                'message' => $loggedUser->nome . ', seus dados foram atualizados com sucesso!',
                'issuccess' => true
            ]);

        } catch (Exception $ex) {            
            SessionManager::setFlashMessage([
                'icon' => 'error',
                'message' => 'Erro ao atualizar os dados: ' . $ex->getMessage()
            ]);
        }
    }

    header('Location: ../../index.php#atualizar');
?>