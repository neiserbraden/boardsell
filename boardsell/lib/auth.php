<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function require_user() {
    if (empty($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
}

function require_admin() {
    if (empty($_SESSION['admin_id'])) {
        header("Location: ../admin_login.php");
        exit;
    }
}

function get_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function require_valid_csrf() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (
            empty($_POST['csrf_token']) ||
            empty($_SESSION['csrf_token']) ||
            !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
        ) {
            die("Invalid CSRF token");
        }
    }
}
