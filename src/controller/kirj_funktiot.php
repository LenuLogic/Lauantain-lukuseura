<?php 

function tarkistaKirjautuminen($email="", $salasana="") {
    require_once(MODEL_DIR . 'henk_funktiot.php');
    $tiedot = haeHenkiloSahkopostilla($email);
    $tiedot = array_shift($tiedot);

    if ($tiedot && password_verify($salasana, $tiedot['salasana'])) {
        return true;
    }
    return false;
}