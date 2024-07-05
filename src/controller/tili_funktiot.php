<?php

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

// Tämä muutettu viimeksi
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
// Tähän loppuu
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

function lahetaVahv_avain($email, $url) {
    $message = "Hei!\n\n" .
    "Olet rekisteröitynyt Lauantain lukuseura -palveluun tällä sähköpostiosoitteella.\n" . 
    "Klikkaamalla alla olevaa linkkiä vahvistat käyttämäsi sähköpostiosoitteen\n" .
    "ja pääset käyttämään palvelua.\n\n" . 
    "$url\n\n" .
    "Jos et ole rekisteröitynyt Lauantain lukuseura -palveluun, tämä sähköposti on tullut sinulle vahingossa.\n" .
    "Siinä tapauksessa ole hyvä ja poista tämä viesti.\n\n" .
    "Terveisin \n" . 
    "Lauantain lukuseura";
    return mail($email, 'Lauantain lukuseura -tilin aktivointilinkki', $message);
}

?>