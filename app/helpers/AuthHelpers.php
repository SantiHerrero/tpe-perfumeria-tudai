<?php
class AuthHelper {
    public static function checkLoggedIn() {
        session_start();
        if (!isset($_SESSION['USER_ID'])) {
            header('Location: ' . BASE_URL . 'login');
            die();
        }
    }
}