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
            require_once MODEL_DIR . 'henkilo.php';
            $salasana = password_hash($_POST['salasana1'], PASSWORD_DEFAULT);
            $id = lisaaHenkilo($_POST['nimi'], $_POST['email'], $salasana);
            echo "Tili on luotu tunnisteella $id";
            break;
        } else {
        echo $templates->render('lisaa_tili');
        break;
        }
    default:
        echo $templates->render('notfound');
}

?>

<!-- https://neutroni.hayo.fi/~lkevatky/lukupiiri/ -->