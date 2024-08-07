<?php 

function tarkistaKirjautuminen($email="", $salasana="") {
    require_once(MODEL_DIR . 'henk_funktiot.php');
    $tiedot = haeHenkilo($email);

    if ($tiedot && password_verify($salasana, $tiedot['salasana'])) {
        return true;
    }
    return false;
}

function logout() {
    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]);
    }
    session_destroy();
}

?>