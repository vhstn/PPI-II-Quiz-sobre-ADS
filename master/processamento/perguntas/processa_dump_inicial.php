<?php
    include_once '../session_manager.php';

    SessionManager::start();
    SessionManager::requireAdminUser();

    try {
        $connection = ConnectionManager::getConnection();

        $connection->query("DELETE FROM PERGUNTAOPCOES");
        $connection->query("DELETE FROM PERGUNTAS");
        $connection->query("ALTER TABLE PERGUNTAS AUTO_INCREMENT = 1");

        $connection->query("INSERT INTO PERGUNTAS (TEXTO) VALUES ('Qual tag HTML é usada para criar um hyperlink para outra página?')");
        $connection->query("INSERT INTO PERGUNTAOPCOES (IDPERGUNTA, TEXTO, CORRETA, IDENTIFICADOR) VALUES 
        (1, '<link>', 'N', 'A'),
        (1, '<a>', 'S', 'B'),
        (1, '<href>', 'N', 'C'),
        (1, '<p>', 'N', 'D')");

        $connection->query("INSERT INTO PERGUNTAS (TEXTO) VALUES ('Qual propriedade CSS é usada para alterar a cor do texto de um elemento?')");
        $connection->query("INSERT INTO PERGUNTAOPCOES (IDPERGUNTA, TEXTO, CORRETA, IDENTIFICADOR) VALUES 
        (2, 'font-color', 'N', 'A'),
        (2, 'text-style', 'N', 'B'),
        (2, 'text-color', 'N', 'C'),
        (2, 'color', 'S', 'D')");

        $connection->query("INSERT INTO PERGUNTAS (TEXTO) VALUES ('Como se declara uma variável que não pode ser reatribuída em JavaScript (ES6+)?')");
        $connection->query("INSERT INTO PERGUNTAOPCOES (IDPERGUNTA, TEXTO, CORRETA, IDENTIFICADOR) VALUES 
        (3, 'let', 'N', 'A'),
        (3, 'var', 'N', 'B'),
        (3, 'const', 'S', 'C'),
        (3, 'static', 'N', 'D')");

        $connection->query("INSERT INTO PERGUNTAS (TEXTO) VALUES ('Qual é o operador usado para concatenar strings em PHP?')");
        $connection->query("INSERT INTO PERGUNTAOPCOES (IDPERGUNTA, TEXTO, CORRETA, IDENTIFICADOR) VALUES 
        (4, '+ (sinal de mais)', 'N', 'A'),
        (4, '. (ponto)', 'S', 'B'),
        (4, '& (e comercial)', 'N', 'C'),
        (4, ', (vírgula)', 'N', 'D')");

        $connection->query("INSERT INTO PERGUNTAS (TEXTO) VALUES ('Qual cláusula SQL é usada para filtrar resultados em uma consulta SELECT, baseada em uma condição?')");
        $connection->query("INSERT INTO PERGUNTAOPCOES (IDPERGUNTA, TEXTO, CORRETA, IDENTIFICADOR) VALUES 
        (5, 'GROUP BY', 'N', 'A'),
        (5, 'ORDER BY', 'N', 'B'),
        (5, 'FILTER', 'N', 'C'),
        (5, 'WHERE', 'S', 'D')");

        SessionManager::setFlashMessage([
            'icon' => 'success',
            'message' => 'Dump inicial realizado com sucesso!'
        ]);
    } catch (Exception $ex) {
        SessionManager::setFlashMessage([
            'icon' => 'error',
            'message' => 'Falha ao aplicar o dump inicial: ' . $ex->getMessage()
        ]);
    }

    header('Location: ../../index.php#perguntas');
?>