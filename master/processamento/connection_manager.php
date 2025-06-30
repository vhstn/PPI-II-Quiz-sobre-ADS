<?php
    class ConnectionManager {
        static function getConnection() {
            return new mysqli("localhost:3306", "root", "", "QUIZ_ADS");
        }
    }

    $erro = false;
    $mensagem = '';
    try {
        ConnectionManager::getConnection();
    } catch (Exception $ex) {
        $erro = true;
        $mensagem = 'Erro ao conectar com o banco de dados: ' . $ex->getMessage();
    }
?>

<?php if($erro): ?>
    <script>
        Swal.fire({
          icon: 'error',
          title: <?= json_encode($mensagem) ?>,
          confirmButtonText: 'OK'
        });
    </script>
    <?php die(); ?>
<?php endif; ?>