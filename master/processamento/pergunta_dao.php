<?php
    include_once 'connection_manager.php';

    class Pergunta {
        public $id;
        public $texto;
        public $opcoes;

        function getId() {
            return $this->id;
        }

        function __construct($texto = null, $opcoes = []) {
            $this->texto = $texto;
            $this->opcoes = $opcoes;
        }

        function persistir() {
            $connection = ConnectionManager::getConnection();
            $prepared_statement = $connection->prepare("INSERT INTO PERGUNTAS (TEXTO) VALUES (?)");
            $prepared_statement->bind_param("s", $this->texto);

            if ($prepared_statement->execute()) {
                $this->id = $connection->insert_id;
            }
        }

        function atualizar() {
            $connection = ConnectionManager::getConnection();
            $prepared_statement = $connection->prepare("UPDATE PERGUNTAS SET TEXTO = ? WHERE ID = ?");
            $prepared_statement->bind_param("si", $this->texto, $this->id);

            $prepared_statement->execute();
        }

        function opcaoCorreta() {
            $opcaoCorreta = array_filter(
                $this->opcoes,
                fn($opcao) => $opcao->correta === 'S'
            );

            return current($opcaoCorreta);
        }

        static function buscarTodas() {
            $connection = ConnectionManager::getConnection();

            $stmt = $connection->prepare("SELECT ID, TEXTO FROM PERGUNTAS");
            if ($stmt === false) {
                die("Erro no prepare: " . $connection->error);
            }

            $stmt->execute();
        
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $perguntas = [];

                while ($row = $result->fetch_assoc()) {
                    $pergunta = new Pergunta();
                    $pergunta->id = $row['ID'];
                    $pergunta->texto = $row['TEXTO'];
                    $pergunta->opcoes = Opcao::buscarOpcoesDaPergunta($row['ID']);
                    
                    $perguntas[] = $pergunta;
                }

                return $perguntas;
            }
        
            return null;
        }

        static function excluir($idPergunta) {
            $connection = ConnectionManager::getConnection();

            $prepared_statement_1 = $connection->prepare("DELETE FROM PERGUNTAOPCOES WHERE IDPERGUNTA = ?");
            $prepared_statement_1->bind_param("i", $idPergunta);
            $prepared_statement_1->execute();

            $prepared_statement_2 = $connection->prepare("DELETE FROM PERGUNTAS WHERE ID = ?");
            $prepared_statement_2->bind_param("i", $idPergunta);
            $prepared_statement_2->execute();
        }

    }

    class Opcao {
        public $id;
        public $idPergunta;
        public $texto;
        public $correta;
        public $identificador;

        function __construct($idPergunta = null, $texto = null, $identificador = null, $correta = "N") {
            $this->idPergunta = $idPergunta;
            $this->texto = $texto;
            $this->correta = $correta;
        }

        function persistir() {
            $connection = ConnectionManager::getConnection();
            $prepared_statement = $connection->prepare("INSERT INTO PERGUNTAOPCOES (IDPERGUNTA, TEXTO, CORRETA, IDENTIFICADOR) VALUES (?, ?, ?, ?)");
            $prepared_statement->bind_param("isss", $this->idPergunta, $this->texto, $this->correta, $this->identificador);

            if ($prepared_statement->execute()) {
                $this->id = $connection->insert_id;
            }
        }

        function atualizar() {
            $connection = ConnectionManager::getConnection();
            $prepared_statement = $connection->prepare("UPDATE PERGUNTAOPCOES SET TEXTO = ?, CORRETA = ? WHERE ID = ?");
            $prepared_statement->bind_param("ssi", $this->texto, $this->correta ,$this->id);

            $prepared_statement->execute();
        }

        static function buscarOpcoesDaPergunta($idPergunta) {
            $connection = ConnectionManager::getConnection();

            $stmt = $connection->prepare("SELECT ID, IDPERGUNTA, TEXTO, CORRETA, IDENTIFICADOR FROM PERGUNTAOPCOES WHERE IDPERGUNTA = ?");
            if ($stmt === false) {
                die("Erro no prepare: " . $connection->error);
            }

            $stmt->bind_param("i", $idPergunta);
            $stmt->execute();
        
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $opcoes = [];

                while ($row = $result->fetch_assoc()) {
                    $opcao = new Opcao();
                    $opcao->id = $row['ID'];
                    $opcao->idPergunta = $row['IDPERGUNTA'];
                    $opcao->texto = $row['TEXTO'];
                    $opcao->correta = $row['CORRETA'];
                    $opcao->identificador = $row['IDENTIFICADOR'];
                    
                    $opcoes[] = $opcao;
                }

                return $opcoes;
            }
        
            return null;
        }
    }
?>