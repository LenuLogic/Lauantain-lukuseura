<?php
require_once HELPERS_DIR . 'DB.php';

function lisaaHenkilo($nimi, $email, $salasana) {
    DB::run('INSERT INTO lp_henkilo (nimi, email, salasana) VALUES (?,?,?);', [$nimi, $email, $salasana]);
    return DB::lastInsertID();
}

// Tarkistaa rekisteröitymisen yhteydessä, löytyykö sähköpostiosoite taulusta jo ennestään.
function haeHenkiloSahkopostilla($email) {
    return DB::run('SELECT * FROM lp_henkilo WHERE email = ?;', [$email])->fetchAll();
}

// Sama kuin yllä mutta palauttaa kaikkien rivien sijaan vain ensimmäisen rivin.
function haeHenkilo($email) {
    return DB::run('SELECT * FROM lp_henkilo WHERE email = ?;', [$email])->fetch();
}

?>