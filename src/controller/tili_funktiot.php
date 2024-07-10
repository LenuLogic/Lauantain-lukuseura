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
        } else { 
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

function lahetaVaihtoavain($email, $url) {
    $message = "Hei!\n\n" .
    "Olet pyytänyt tilisi salasanan vaihtoa. Pääset vaihtamaan salasanasi klikkaamalla alla olevaa linkkiä.\n" .
    "Linkki on voimassa 30 minuuttia.\n\n" .
    "$url\n\n" .
    "Jos et ole pyytänyt tilisi salasanan vaihtoa, voit poistaa tämän viestin turvallisesti.\n\n" .
    "Terveisin\n" . 
    "Lauantain lukuseura";
    return mail($email, 'Tilin salasanan vaihtaminen', $message);
}

function luoVaihtoavain($email, $baseurl='') {
    require_once(HELPERS_DIR . "secret.php");
    $avain = generateResetCode($email);
    $url = 'https://' . $_SERVER['HTTP_HOST'] . $baseurl . "/reset?key=$avain";
    require_once(MODEL_DIR . 'henk_funktiot.php');

    if (asetaVaihtoavain($email, $avain) && lahetaVaihtoavain($email, $url)) {
        return [
            "status" => 200,
            "email" => $email,
            "resetkey" => $avain
        ];
    } else {
        return [
            "status" => 500,
            "email" => $email
        ];
    }
}

function resetoiSalasana($formdata, $resetkey='') {
    require_once(MODEL_DIR . 'henk_funktiot.php');
    $error="";

    if (isset($formdata['salasana1']) && $formdata['salasana1'] &&
        isset($formdata['salasana2']) && $formdata['salasana2']) {
            if ($formdata['salasana1'] != $formdata['salasana2']) {
                $error = "Salasanat eivät täsmää. ";
            }
        } else {
            $error = "Syötä salasana kahteen kertaan.";
        }
    
    if (!$error) {
        $salasana = password_hash($formdata['salasana1'], PASSWORD_DEFAULT);
        $rowcount = vaihdaSalasanaAvaimella($salasana, $resetkey);

        if ($rowcount) {
            return [
                "status" => 200,
                "resetkey" => $resetkey
            ];
        } else {
            return [
                "status" => 500,
                "resetkey" => $resetkey
            ];
        }
    } else {
        return [
            "status" => 400,
            "resetkey" => $resetkey,
            "error" => $error
        ];
    }

}

?>