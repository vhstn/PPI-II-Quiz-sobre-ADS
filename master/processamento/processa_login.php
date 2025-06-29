<?php

  include_once 'session_manager.php';
  include_once 'usuario_dao.php';

  SessionManager::start();

  $mensagem = "";
  $icon = "";

  if (isset($_REQUEST["email"])) {
    try {
      $email = $_REQUEST["email"];
      $senha = $_REQUEST["senhaHash"];
      
      $usuario = Usuario::buscaPorEmailESenha($email, $senha);

      if ($usuario == null) {
        throw new Exception("Usuário ou senha incorretos.");
      }

      SessionManager::setLoggedUser($usuario);

      SessionManager::setFlashMessage([
        'icon' => 'success',
        'message' => 'Login realizado com sucesso. <br>Bem vindo(a), ' . $usuario->nome . '!',
        'issuccess' => true
      ]);

    } catch (Exception $ex) {
       SessionManager::setFlashMessage([
        'icon' => 'error',
        'message' => 'Erro no login: ' . $ex->getMessage()
      ]);
    }
  }

  header('Location: ../index.php#login');
  exit();
?>