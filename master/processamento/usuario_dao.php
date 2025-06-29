<?php
    include 'connection_manager.php';

    class Usuario {
        public $id;
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

        static function excluir($usuarioId) {
            $connection = ConnectionManager::getConnection();

            $prepared_statement = $connection->prepare("DELETE FROM USUARIOPONTUACOES WHERE IDUSUARIO = ?");
            $prepared_statement->bind_param("i", $usuarioId);
            $prepared_statement->execute();

            $prepared_statement = $connection->prepare("DELETE FROM USUARIOS WHERE ID = ?");
            $prepared_statement->bind_param("i", $usuarioId);
            $prepared_statement->execute();
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

        function adicionarPontuacao($qtdPerguntas, $qtdAcertos) {
            $connection = ConnectionManager::getConnection();

            $percentual = 0;
            if ($qtdPerguntas > 0) {
                $percentual = ($qtdAcertos / $qtdPerguntas) * 100;
            }

            $prepared_statement = $connection->prepare("INSERT INTO USUARIOPONTUACOES (IDUSUARIO, QTDACERTOS, QTDQUESTOES, PERCENTUAL) VALUES (?, ?, ?, ?)");
            $prepared_statement->bind_param("iiid", $this->id, $qtdAcertos, $qtdPerguntas, $percentual);

            $prepared_statement->execute();
        }

        function buscarPontuacoes() {
            $connection = ConnectionManager::getConnection();

            $stmt = $connection->prepare("SELECT ID, IDUSUARIO, QTDACERTOS, QTDQUESTOES, PERCENTUAL, DATA FROM USUARIOPONTUACOES WHERE IDUSUARIO = ? ORDER BY DATA DESC LIMIT 5");
            if ($stmt === false) {
                die("Erro no prepare: " . $connection->error);
            }

            $stmt->bind_param("i", $this->id);
            $stmt->execute();
        
            $result = $stmt->get_result();
        
            if ($result->num_rows > 0) {
                $pontuacoes = [];

                while ($row = $result->fetch_assoc()) {
                    $pontuacao = new Pontuacao();
                    $pontuacao->id = $row['ID'];
                    $pontuacao->idUsuario = $row['IDUSUARIO'];
                    $pontuacao->qtdAcertos = $row['QTDACERTOS'];
                    $pontuacao->qtdPerguntas = $row['QTDQUESTOES'];
                    $pontuacao->percentual = $row['PERCENTUAL'] . '%';
                    $pontuacao->data = (new DateTime($row['DATA']))->format('d/m/Y');

                    $pontuacoes[] = $pontuacao;
                }
    
                return $pontuacoes;
            }
        
            return null;
        }
    }

    class Pontuacao {
        public $id;
        public $idUsuario;
        public $qtdAcertos;
        public $qtdPerguntas;
        public $percentual;
        public $data;
    }
?>