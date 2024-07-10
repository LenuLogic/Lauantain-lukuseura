<?php
require_once HELPERS_DIR . 'DB.php';

function haeTapahtumat() {
    return DB::run('SELECT * FROM lp_tapahtuma ORDER BY tap_alkaa;')->fetchAll();
}

function haeTapahtuma($id) {
    return DB::run('SELECT * FROM lp_tapahtuma WHERE idtapahtuma = ?;',[$id])->fetch();
}

// nimi, kuvaus, tap_alkaa, tap_loppuu
function lisaaTapahtuma($nimi, $kuvaus, $tap_alkaa, $tap_loppuu) {
    DB::run('INSERT INTO lp_tapahtuma (nimi, kuvaus, tap_alkaa, tap_loppuu) VALUES (?,?,?,?);', [$nimi, $kuvaus, $tap_alkaa, $tap_loppuu]);
    return DB::lastInsertID();
}


function tarkistaTapahtuma($formdata) {
    $error=[];

    if (!isset($formdata['nimi']) || !$formdata['nimi']) {
        $error['nimi'] = "Syötä tapahtuman nimi.";
        } else {
            if (!preg_match("/^[- '\p{L}]+$/u", $formdata['nimi'])) {
            $error['nimi'] = "Syötä nimi ilman erikoismerkkejä.";
            }
        }

    if (!isset($formdata['kuvaus']) || !$formdata['kuvaus']) {
        $error['kuvaus'] = "Syötä tapahtuman kuvaus.";
        } else {
            if (!preg_match("/^[- '\p{L}]+$/u", $formdata['nimi'])) {
            $error['kuvaus'] = "Syötä kuvaus ilman erikoismerkkejä."; 
            // Tarvitaanko tätä? Voiko suodattaa muuten? Riittääkö,
            // että SQL siistii datan? Ei ehkä. Tarkista jostain.
            // Saako tämän suodatettua tekstiksi/stringiksi?
            }
        }
    
    if (!isset($formdata['tap_alkaa_pvm']) || !$formdata['tap_alkaa_pvm']) {
        $error['tap_alkaa_pvm'] = "Syötä tapahtuman alkamispäivä.";
        } else {
            if (!preg_match("/^[- '\p{L}]+$/u", $formdata['tap_alkaa_pvm'])) {
            $error['tap_alkaa_pvm'] = "Syötä alkamispäivä ilman erikoismerkkejä.";
            }
        }
        // Tuleeko joku, mikä tarkistaa oikean muodon? Entä kalenterinäkymä?
    
    if (!isset($formdata['tap_loppuu_pvm']) || !$formdata['tap_loppuu_pvm']) {
        $error['tap_loppuu_pvm'] = "Syötä tapahtuman päättymispäivä.";
        } else {
            if (!preg_match("/^[- '\p{L}]+$/u", $formdata['tap_loppuu_pvm'])) {
            $error['tap_loppuu_pvm'] = "Syötä päättymispäivä ilman erikoismerkkejä.";
            }
        }
        // Tuleeko joku, mikä tarkistaa oikean muodon? Entä kalenterinäkymä?

    
    if (!$error) {
        $nimi = $formdata['nimi'];
        $kuvaus = $formdata['kuvaus'];
        $tap_alkaa_pvm = $formdata['tap_alkaa_pvm'];
        $tap_loppuu_pvm = $formdata['tap_loppuu_pvm'];

        /* Tarvitaanko näitä ollenkaan)
        $idhenkilo = lisaaHenkilo($nimi, $email, $salasana);

        if ($idhenkilo) {
            require_once(HELPERS_DIR . "secret.php");
            $avain = generateActivationCode($email);
            $url = 'https://' . $_SERVER['HTTP_HOST'] . $baseurl . "/vahvista?key=$avain";
            
            if (paivitaVahv_avain($email, $avain) && lahetaVahv_avain($email, $url)) {
                return [
                    "status" => 200,
                    "id" => $idhenkilo,
                    "data" => $formdata
                ];
            } else {
                return [
                    "status" => 500,
                    "data" => $formdata
                ];
            }           
        } else {
            return [
                "status" => 500,
                "data" => $formdata,
            ];
        }
    } else {
        return [
            "status" => 400,
            "data" => $formdata,
            "error" => $error
        ];
    */
    }
}

/*
function lisaaTili($formdata, $baseurl='') {
    require_once(MODEL_DIR . 'henk_funktiot.php');
    $error =[];
    if (!isset($formdata['nimi']) || !$formdata['nimi']) {
        $error['nimi'] = "Syötä nimi.";
    } else {
        if (!preg_match("/^[- '\p{L}]+$/u", $formdata['nimi'])) {
            $error['nimi'] = "Syötä nimi ilman erikoismerkkejä.";
        }
    }

    if (!isset($formdata['email']) || !$formdata['email']) {
        $error['email'] = "Syötä sähköpostiosoite.";
    } else {
        if (!filter_var($formdata['email'], FILTER_VALIDATE_EMAIL)) {
            $error['email'] = "Sähköpostiosoite on virheellisessä muodossa.";
        } else { 
            if (haeHenkiloSahkopostilla($formdata['email'])) {
                $error['email'] = "Sähköpostiosoite on jo käytössä.";
            }
        }
    }
    
    if (isset($formdata['salasana1']) && $formdata['salasana1'] &&
        isset($formdata['salasana2']) && $formdata['salasana2']) {
            if ($formdata['salasana1'] != $formdata['salasana2']) {
                $error['salasana'] = "Salasanat eivät täsmää.";
            }
        } else { // rivi 29: illegal string offset 'salasana.
            $error['salasana'] = "Syötä salasana kahteen kertaan."; 
        }
    
    if (!$error) {
        $nimi = $formdata['nimi'];
        $email = $formdata['email'];
        $salasana = password_hash($formdata['salasana1'], PASSWORD_DEFAULT);

        $idhenkilo = lisaaHenkilo($nimi, $email, $salasana);

        if ($idhenkilo) {
            require_once(HELPERS_DIR . "secret.php");
            $avain = generateActivationCode($email);
            $url = 'https://' . $_SERVER['HTTP_HOST'] . $baseurl . "/vahvista?key=$avain";
            
            if (paivitaVahv_avain($email, $avain) && lahetaVahv_avain($email, $url)) {
                return [
                    "status" => 200,
                    "id" => $idhenkilo,
                    "data" => $formdata
                ];
            } else {
                return [
                    "status" => 500,
                    "data" => $formdata
                ];
            }           
        } else {
            return [
                "status" => 500,
                "data" => $formdata,
            ];
        }
    } else {
        return [
            "status" => 400,
            "data" => $formdata,
            "error" => $error
        ];
    }
}
*/

?>