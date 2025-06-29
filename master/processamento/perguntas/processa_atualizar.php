<?php
    include_once '../session_manager.php';
    include_once '../pergunta_dao.php';

    SessionManager::start();
    SessionManager::requireAdminUser();

    if (isset($_REQUEST['id'])) {
        try {
            $pergunta = new Pergunta();
            $pergunta->id = $_REQUEST['id'];
            $pergunta->texto = $_REQUEST['pergunta'];
            $pergunta->opcoes = Opcao::buscarOpcoesDaPergunta($_REQUEST['id']);

            $pergunta->atualizar();

            foreach ($pergunta->opcoes as $opcao) {
                $nome_request = 'opcao_' . $opcao->identificador;
                $opcao->texto = $_REQUEST[$nome_request];
                $opcao->correta = $_REQUEST['correta'] == $opcao->identificador ? 'S' : 'N';

                $opcao->atualizar();
            }

            SessionManager::setFlashMessage([
                'icon' => 'success',
                'message' => 'Pergunta alterada com sucesso!'
            ]);

        } catch (Exception $ex) {
            SessionManager::setFlashMessage([
                'icon' => 'error',
                'message' => 'Houve um erro ao alterar a pergunta: ' . $ex->getMessage()
            ]);
        }
    }

    header('Location: ../../index.php#perguntas');
?>