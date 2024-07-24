<?php
session_start();
require_once '../include/database.php';

function is_user_logged_in(): bool {
    return isset($_SESSION['username']);
}

function redirect_to(string $url): void {
    header('Location: ' . $url);
    header('HTTP/1.1 302 Found');
    exit;
}

function logout(): void {
    if (is_user_logged_in()) {
        unset($_SESSION['username'], $_SESSION['user_id']);
        session_destroy();
        redirect_to('login.php');
    } else {
        echo 'No user is logged in.';
    }
}

logout();
?>
