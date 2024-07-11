<?php
require_once HELPERS_DIR . 'DB.php';

function haeTapahtumat() {
    return DB::run('SELECT * FROM lp_tapahtuma ORDER BY alkaa_pvm;')->fetchAll();
}

function haeTapahtuma($id) {
    return DB::run('SELECT * FROM lp_tapahtuma WHERE idtapahtuma = ?;',[$id])->fetch();
}

function lisaaTapahtuma($nimi, $kuvaus, $alkaa_pvm, $alkaa_klo, $loppuu_pvm, $loppuu_klo) {
    DB::run('INSERT INTO lp_tapahtuma (nimi, kuvaus, alkaa_pvm, alkaa_klo, loppuu_pvm, loppuu_klo) VALUES (?,?,?,?,?,?);', [$nimi, $kuvaus, $alkaa_pvm, $alkaa_klo, $loppuu_pvm, $loppuu_klo]);
    return DB::lastInsertID();
}


function tarkistaTapahtuma($formdata) {
    // require_once(MODEL_DIR . 'tap_funktiot.php'); // Tarvitaanko tätä?
    $error=[];

    if (!isset($formdata['nimi']) || !$formdata['nimi']) {
        $error['nimi'] = "Syötä tapahtuman nimi.";
        } else {
            if (!preg_match("/^[0-9-?! '\p{L}]+$/u", $formdata['nimi'])) {
            $error['nimi'] = "Syötä nimi ilman erikoismerkkejä.";
            }
        }

    if (!isset($formdata['kuvaus']) || !$formdata['kuvaus']) {
        $error['kuvaus'] = "Syötä tapahtuman kuvaus.";
        } else {
            if (!preg_match("/^[0-9-.!? '\p{L}]+$/u", $formdata['nimi'])) {
            $error['kuvaus'] = "Syötä kuvaus ilman erikoismerkkejä."; 
            // Tarvitaanko tätä? Voiko suodattaa muuten? Riittääkö,
            // että SQL siistii datan? Ei ehkä. Tarkista jostain.
            // Saako tämän suodatettua tekstiksi/stringiksi?
            }
        }
    // Alkamispäivä
    if (!isset($formdata['alkaa_pvm']) || !$formdata['alkaa_pvm']) {
        $error['alkaa_pvm'] = "Syötä tapahtuman alkamispäivä.";
        } else {
            if (!preg_match("/^[0-9-]+$/", $formdata['alkaa_pvm'])) {
            $error['alkaa_pvm'] = "Syötä alkamispäivä pyydetyssä muodossa.";
            }
        }

    // Alkamisaika
    if (!isset($formdata['alkaa_klo']) || !$formdata['alkaa_klo']) {
        $error['alkaa_klo'] = "Syötä tapahtuman alkamisaika.";
        } else {
            if (!preg_match("/^[0-9:]+$/", $formdata['alkaa_klo'])) {
            $error['alkaa_klo'] = "Syötä alkamisaika pyydetyssä muodossa.";
            }
        }

    //Loppumispäivä
    if (!isset($formdata['loppuu_pvm']) || !$formdata['loppuu_pvm']) {
        $error['loppuu_pvm'] = "Syötä tapahtuman päättymispäivä.";
        } else {
            if (!preg_match("/^[0-9-]+$/", $formdata['loppuu_pvm'])) {
            $error['loppuu_pvm'] = "Syötä päättymispäivä pyydetyssä muodossa.";
            }
        }

    //Loppumisaika
    if (!isset($formdata['loppuu_klo']) || !$formdata['loppuu_klo']) {
        $error['loppuu_klo'] = "Syötä tapahtuman päättymisaika.";
        } else {
            if (!preg_match("/^[0-9:]+$/u", $formdata['loppuu_klo'])) {
            $error['loppuu_klo'] = "Syötä päättymisaika pyydetyssä muodossa.";
            }
        }
    
    if (!$error) {
        $nimi = $formdata['nimi'];
        $kuvaus = $formdata['kuvaus'];
        $alkaa_pvm = $formdata['alkaa_pvm'];
        $alkaa_klo = $formdata['alkaa_klo'];
        $loppuu_pvm = $formdata['loppuu_pvm'];
        $loppuu_klo = $formdata['loppuu_klo'];

        $idtapahtuma = lisaaTapahtuma($nimi, $kuvaus, $alkaa_pvm, $alkaa_klo, $loppuu_pvm, $loppuu_klo);

        if ($idtapahtuma) {
            return [
                "status" => 200,
                "id" => $idtapahtuma,
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
            "status" => 400,
            "data" => $formdata,
            "error" => $error
        ];
    }
}

        /*
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