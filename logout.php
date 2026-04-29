<?php

require_once 'config.php';

$_SESSION = array();

// 3. Jika ingin menghapus session secara total termasuk cookie session di browser
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

header("Location: index.php");

exit();
?>