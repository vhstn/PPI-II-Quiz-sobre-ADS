<?php
    class ConnectionManager {
        static function getConnection() {
            return new mysqli("localhost:3306", "root", "", "QUIZ_ADS");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connection manager</title>
</head>
<body>
    <?php
        try {
            ConnectionManager::getConnection();
        } catch (Exception $ex) {
            echo "<h1>Erro ao realizar a conexão: " . $ex->getMessage() . "</h1>";
        }
    ?>
</body>
</html>