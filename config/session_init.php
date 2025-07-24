<?php
// session_init.php
if (session_status() == PHP_SESSION_NONE) {
    $customSessionPath = __DIR__ . "/sessions";
    if (!is_dir($customSessionPath)) {
        mkdir($customSessionPath, 0777, true);
    }
    session_save_path($customSessionPath);
    session_start();
}
