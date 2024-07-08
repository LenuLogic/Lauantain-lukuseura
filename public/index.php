<?php
session_start();
require_once '../src/init.php';

if (isset($_SESSION['user'])) {
    require_once MODEL_DIR . 'henk_funktiot.php';
    $loggeduser = haeHenkilo($_SESSION['user']);
} else {
    $loggeduser = NULL;
}

$request = str_replace($config['urls']['baseUrl'],'',$_SERVER['REQUEST_URI']);
$request = strtok($request, '?');

$templates = new League\Plates\Engine(TEMPLATE_DIR);

switch ($request) {
    case '/':
    case '/tapahtumat':
        require_once MODEL_DIR . 'tap_funktiot.php';
        $tapahtumat = haeTapahtumat();
        echo $templates->render('tapahtumat',['tapahtumat' => $tapahtumat]);
        break;
   
        case '/tapahtuma':
        require_once MODEL_DIR . 'tap_funktiot.php';
        require_once MODEL_DIR . 'ilmo_funktiot.php';
        $tapahtuma = haeTapahtuma($_GET['id']);
        if ($tapahtuma) {
            if ($loggeduser) {
                $ilmoittautuminen = haeIlmoittautuminen($loggeduser['idhenkilo'],$tapahtuma['idtapahtuma']);
            } else {
                $ilmoittautuminen = NULL;
            }
            echo $templates->render('tapahtuma',['tapahtuma' => $tapahtuma,
                                                'ilmoittautuminen' => $ilmoittautuminen,
                                                'loggeduser' => $loggeduser]);
        } else {
            echo $templates->render('tapahtumanotfound');
        }
        break;
    
    case '/lisaa_tili':
        if (isset($_POST['laheta'])) {
            $formdata = cleanArrayData($_POST);
            require_once CONTROLLER_DIR . 'tili_funktiot.php';
            $tulos = lisaaTili($formdata,$config['urls']['baseUrl']);
            if ($tulos['status'] == "200") {
                echo $templates->render('tili_luotu', ['formdata' => $formdata]);
                break;
            }
            echo $templates->render('lisaa_tili', ['formdata' => $formdata, 'error' => $tulos['error']]);
            break;
        } else {
        echo $templates->render('lisaa_tili', ['formdata' => [], 'error' => []]);
        break;
        }

    case '/kirjaudu':
        if (isset($_POST['laheta'])) {
            require_once CONTROLLER_DIR . 'kirj_funktiot.php';
            if (tarkistaKirjautuminen($_POST['email'],$_POST['salasana'])) {
                require_once MODEL_DIR . 'henk_funktiot.php';
                $user = haeHenkilo($_POST['email']);
                if ($user['vahvistettu']) {
                    session_regenerate_id();
                    $_SESSION['user'] = $user['email'];
                    $_SESSION['admin'] = $user['admin'];
                    header("Location: " . $config['urls']['baseUrl']);
                } else {
                    echo $templates->render('kirjaudu', ['error' => ['virhe' => 'Tili on vahvistamatta! Ole hyvä ja vahvista tili sähköpostissa olevalla linkillä.']]);
                }
            } else {
                echo $templates->render('kirjaudu', ['error' => ['virhe' => 'Väärä käyttäjätunnus tai salasana!']]);
            }
        } else {
            echo $templates->render('kirjaudu', ['error' => []]);
        }
        break;
    
    case '/logout':
        require_once CONTROLLER_DIR . 'kirj_funktiot.php';
        logout();
        header("Location: " . $config['urls']['baseUrl']);
        break;

    case '/ilmoittaudu':
        if ($_GET['id']) {
            require_once MODEL_DIR . 'ilmo_funktiot.php';
            $idtapahtuma = $_GET['id'];
            if ($loggeduser) {
                lisaaIlmoittautuminen($loggeduser['idhenkilo'], $idtapahtuma);
            }
            header("Location: tapahtuma?id=$idtapahtuma");
        } else {
            header("Location: tapahtumat");
        }
        break;

    case '/peru':
        if ($_GET['id']) {
            require_once MODEL_DIR . 'ilmo_funktiot.php';
            $idtapahtuma = $_GET['id'];
            if ($loggeduser) {
                poistaIlmoittautuminen($loggeduser['idhenkilo'],$idtapahtuma);
            }
            header("Location: tapahtuma?id=$idtapahtuma");
        } else {
            header("Location: tapahtumat");
        }
        break;

    case '/vahvista':
        if (isset($_GET['key'])) {
            $key = $_GET['key'];
            require_once MODEL_DIR . 'henk_funktiot.php';
            if (vahvistaTili($key)) {
                echo $templates->render('tili_aktivoitu');
            } else {
                echo $templates->render('tili_aktivointi_virhe');
            }
        } else {
            header("Location: " . $config['urls']['baseUrl']);
        }
        break;

    case '/tilaa_vaihtoavain':
        $formdata = cleanArrayData($_POST);
        if (isset($formdata['laheta'])) {
            // tästä alkaa
            require_once MODEL_DIR . 'henk_funktiot.php';
            $user = haeHenkilo($formdata['email']);
            if ($user) {
                require_once CONTROLLER_DIR . 'tili_funktiot.php';
                $tulos = luoVaihtoavain($formdata['email'], $config['urls']['baseUrl']);
                if ($tulos['status'] == "200") { // Mikä tässä mättää? Tulostaa taulukon
                    echo $templates->render('tilaa_vaihtoavain_lahetetty');
                    break;
                }
                echo $templates->render('virhe'); // päätyy tähän
                break;
            } else {
                echo $templates->render('tilaa_vaihtoavain_lahetetty');
                break;
            }
            // tähän päättyy
        } else {
            echo $templates->render('tilaa_vaihtoavain');
        }
        break;

    case '/reset':
        $resetkey = $_GET['key'];
        require_once MODEL_DIR . 'henk_funktiot.php';
        $rivi = tarkistaVaihtoavain($resetkey);

        if ($rivi) {
            if ($rivi['aikaikkuna'] < 0) {
                echo $templates->render('reset_virhe');
                break;
            }
        } else {
            echo $templates->render('reset_virhe');
            break;
        }

        $formdata = cleanArrayData($_POST);
        if (isset($formdata['laheta'])) {
            require_once CONTROLLER_DIR . 'tili_funktiot.php';
            $tulos = resetoiSalasana($formdata, $resetkey);

            if ($tulos['status'] == "200") {
                echo $templates->render('reset_valmis');
                break;
            }
            echo $templates->render('reset_lomake', ['error' => $tulos['error']]);
            break;
        } else {
            echo $templates->render('reset_lomake', ['error' => '']);
            break;
        }
        break;

    default:
        echo $templates->render('notfound');
}

?>

<!-- https://neutroni.hayo.fi/~lkevatky/lukupiiri/ -->