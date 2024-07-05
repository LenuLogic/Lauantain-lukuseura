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

function paivitaVahv_avain($email, $avain) {
    return DB::run('UPDATE lp_henkilo SET vahv_avain = ? WHERE email = ?', [$avain, $email])->rowCount();
}

function vahvistaTili($avain) {
    return DB::run('UPDATE lp_henkilo SET vahvistettu = TRUE WHERE vahv_avain = ?', [$avain])->rowCount();
}

function asetaVaihtoavain($email, $avain) {
    return DB::run('UPDATE lp_henkilo SET nollausavain = ?, nollausaika = NOW() + INTERVAL 30 MINUTE WHERE email = ?', [$avain, $email])->rowCount();
}

function tarkistaVaihtoavain($avain) {
    return DB::run('SELECT nollausavain, nollausaika-NOW() AS aikaikkuna FROM lp_henkilo WHERE nollausavain = ?', [$avain])->fetch();
}

function vaihdaSalasanaAvaimella($salasana, $avain) {
    return DB::run('UPDATE lp_henkilo SET salasana = ?, nollausavain = NULL, nollausaika = NULL WHERE nollausavain = ?', [$salasana, $avain])->rowCount();
}

?>