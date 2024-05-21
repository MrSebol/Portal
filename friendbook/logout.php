<?php
session_start();

// Zniszcz wszystkie sesje
$_SESSION = array();

// Jeśli jest używany mechanizm sesji ciasteczek, zniszcz ciasteczko
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Zniszcz sesję
session_destroy();

// Przekieruj użytkownika na stronę logowania lub główną
header("Location: login.php");
exit;
?>
