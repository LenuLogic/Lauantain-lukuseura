<?php
require_once HELPERS_DIR . 'DB.php';

function lisaaHenkilo($nimi, $email, $salasana) {
    DB::run('INSERT INTO lp_henkilo (nimi, email, salasana) VALUES (?,?,?);', [$nimi, $email, $salasana]);
    return DB::lastInsertID();
}

?>