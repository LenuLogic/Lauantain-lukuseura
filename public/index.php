<?php
require_once '../src/init.php';

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
        $tapahtuma = haeTapahtuma($_GET['id']);
        if ($tapahtuma) {
            echo $templates->render('tapahtuma',['tapahtuma' => $tapahtuma]);
        } else {
            echo $templates->render('tapahtumanotfound');
        }
        break;
    case '/lisaa_tili':
        if (isset($_POST['laheta'])) {
            $formdata = cleanArrayData($_POST);
            require_once CONTROLLER_DIR . 'tili_funktiot.php';
            $tulos = lisaaTili($formdata);
            if ($tulos['status'] == "200") {
                echo "Tili on luotu tunnisteella $tulos[id]";
            break;
            }
            echo $templates->render('lisaa_tili', ['formdata' => $formdata, 'error' => $tulos['error']]);
            break;
        } else {
        echo $templates->render('lisaa_tili', ['formdata' => [], 'error' => []]);
        break;
        }


    default:
        echo $templates->render('notfound');
}

?>

<!-- https://neutroni.hayo.fi/~lkevatky/lukupiiri/ -->