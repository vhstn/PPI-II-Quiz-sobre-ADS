<?php
    include 'connection_manager.php';

    class Usuario {
        private $id;
        public $nome;
        public $email;
        public $senha;
        public $tipo;

        function __construct($nome = null, $senha = null , $email = null, $tipo = null) {
            $this->nome = $nome;
            $this->email = $email;
            $this->senha = $senha;
            $this->tipo = $tipo;
        }

        static function buscaPorEmailESenha($email, $senha) {
            $connection = ConnectionManager::getConnection();

            $stmt = $connection->prepare("SELECT ID, NOME, EMAIL, TIPO FROM USUARIOS WHERE EMAIL = ? AND SENHA = ?");
            if ($stmt === false) {
                die("Erro no prepare: " . $connection->error);
            }

            $stmt->bind_param("ss", $email, $senha);
            $stmt->execute();
        
            $result = $stmt->get_result();
        
            if ($result->num_rows === 1) {
        
                $row = $result->fetch_assoc();

                $usuario = new Usuario();
                $usuario->id = $row['ID'];
                $usuario->nome = $row['NOME'];
                $usuario->email = $row['EMAIL'];
                $usuario->tipo = $row['TIPO'];
    
                return $usuario;
            }
        
            return null;
        }

        function persistir() {
            $connection = ConnectionManager::getConnection();
            $prepared_statement = $connection->prepare("INSERT INTO USUARIOS (NOME, SENHA, EMAIL, TIPO) VALUES (?, ?, ?, UPPER(?))");
            $prepared_statement->bind_param("ssss", $this->nome, $this->senha, $this->email, $this->tipo);

            if ($prepared_statement->execute()) {
                $this->id = $connection->insert_id;
            }
        }

        function atualizar() {
            $connection = ConnectionManager::getConnection();
            if ($this->senha !== null) {
                $prepared_statement = $connection->prepare("UPDATE USUARIOS SET NOME = ?, SENHA = ?, EMAIL = ?, TIPO = ? WHERE ID = ?");
                $prepared_statement->bind_param("ssssi", $this->nome, $this->senha, $this->email, $this->tipo, $this->id);
                $prepared_statement->execute();
            } else {
                $prepared_statement = $connection->prepare("UPDATE USUARIOS SET NOME = ?, EMAIL = ?, TIPO = ? WHERE ID = ?");
                $prepared_statement->bind_param("sssi", $this->nome, $this->email, $this->tipo, $this->id);
                $prepared_statement->execute();
            }
        }
    }
?>