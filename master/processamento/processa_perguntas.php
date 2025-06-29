<?php
    include_once 'session_manager.php';
    include_once 'pergunta_dao.php';
    
    SessionManager::start();
    SessionManager::requireAdminUser();

    if (isset($_REQUEST['pergunta'])) {
        try {
            $pergunta = new Pergunta($_REQUEST['pergunta']);
            $pergunta->persistir();

            for ($codigo_ascii = 65; $codigo_ascii <= 68; $codigo_ascii++) {
                $caracter = chr($codigo_ascii);
                $nome_request = 'opcao_' . $caracter;

                $opcao = new Opcao();
                $opcao->idPergunta = $pergunta->getId();
                $opcao->identificador = $caracter;
                $opcao->texto = $_REQUEST[$nome_request];
                $opcao->correta = $_REQUEST['correta'] == $caracter ? 'S' : 'N';
                $opcao->persistir();
            }

            SessionManager::setFlashMessage([
                'icon' => 'success',
                'message' => 'Pergunta cadastrada com sucesso!'
            ]);
        } catch (Exception $ex) {
            SessionManager::setFlashMessage([
                'icon' => 'error',
                'message' => 'Erro ao cadastrar pergunta: ' . $ex->getMessage()
            ]);
        }
    }

    header('Location: ../index.php#perguntas');
?>