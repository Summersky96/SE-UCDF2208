<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function generateToken() {
    return bin2hex(random_bytes(32));
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = generateToken();
}
?>
