<?php
  include_once 'usuario_dao.php';
  include_once 'session_manager.php';

  SessionManager::start();

  if (isset($_REQUEST["nome"])) {
    try {
      $nome = $_REQUEST["nome"];
      $email = $_REQUEST["email"];
      $senha = $_REQUEST["senhaHash"];
      $tipo = $_REQUEST["tipo"][0];

      $usuario = new Usuario(
        nome: $nome,
        email: $email,
        senha: $senha,
        tipo: $tipo
      );
  
      $usuario->persistir();

      SessionManager::setFlashMessage([
        'icon' => 'success',
        'message' => 'Cadastro realizado com sucesso!'
      ]);

    } catch (mysqli_sql_exception $ex) {
        $icon = '';
        $message = '';
        
        if ($ex->getCode() == 1062) {
          $icon = 'error';
          $message ='O email ' . $email . ' já está cadastrado na base de dados';
        } else {
          $icon = 'error';
          $message = 'Ocorreu um erro na base de dados: ' . $ex->getMessage();
        }

        SessionManager::setFlashMessage([
          'icon' => $icon,
          'message' => $message
        ]);

    } catch (Exception $ex) {
      SessionManager::setFlashMessage([
        'icon' => 'error',
        'message' => 'Erro no cadastro: ' . $ex->getMessage()
      ]);
    }
  }

  header('Location: ../index.php#cadastro');
?>