<?php
    class SessionManager {
        static function start() {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
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
    }
?>
