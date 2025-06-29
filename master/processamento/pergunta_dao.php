<?php
    include_once 'connection_manager.php';

    class Pergunta {
        private $id;
        public $texto;

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
    }

    class Opcao {
        public $id;
        public $idPergunta;
        public $texto;
        public $correta;

        function __construct($idPergunta = null, $texto = null, $correta = "N") {
            $this->idPergunta = $idPergunta;
            $this->texto = $texto;
            $this->correta = $correta;
        }

        function persistir() {
            $connection = ConnectionManager::getConnection();
            $prepared_statement = $connection->prepare("INSERT INTO PERGUNTAOPCOES (IDPERGUNTA, TEXTO, CORRETA) VALUES (?, ?, ?)");
            $prepared_statement->bind_param("iss", $this->idPergunta, $this->texto, $this->correta);

            if ($prepared_statement->execute()) {
                $this->id = $connection->insert_id;
            }
        }

        static function buscarOpcoesDaPergunta($idPergunta) {
            $connection = ConnectionManager::getConnection();

            $stmt = $connection->prepare("SELECT ID, IDPERGUNTA, TEXTO, CORRETA FROM PERGUNTAOPCOES WHERE IDPERGUNTA = ?");
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
                    
                    $opcoes[] = $opcao;
                }

                return $opcoes;
            }
        
            return null;
        }
    }
?>