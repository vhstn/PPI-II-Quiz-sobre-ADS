<?php
    include_once 'usuario_dao.php';

    class SessionManager {
        static function start() {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        }

        static function destroy() {
            self::start();
            $_SESSION = [];
            session_destroy();

            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
        }

        static function getLoggedUser() {
            if (isset($_SESSION["LOGGEDUSER"])) {
                return $_SESSION["LOGGEDUSER"];
            }
            return null;
        }

        static function setLoggedUser($userInfo) {
            $_SESSION["LOGGEDUSER"] = $userInfo;
        }

        static function requireAuthentication() {
            $loggedUser = self::getLoggedUser();
            if ($loggedUser === null) {
                die("Você precisa estar logado para acessar esta página.");
            }
            return $loggedUser;
        }

        static function requireAdminUser() {
            $loggedUser = self::requireAuthentication();
            if ($loggedUser->tipo !== "A") {
                die('Seu usuário não possui as permissões necessárias para acessar esta página.');
            }
            return $loggedUser;
        }

        static function getFlashMessage($flush = true) {
            if (isset($_SESSION["FLASHMESSAGE"])) {
                $flashMessage = $_SESSION["FLASHMESSAGE"];
                if ($flush) {
                    unset($_SESSION["FLASHMESSAGE"]);
                }
                return $flashMessage;
            }
            return null;
        }

        static function setFlashMessage($flashMessage) {
            $_SESSION["FLASHMESSAGE"] = $flashMessage;
        }
    }
?>
