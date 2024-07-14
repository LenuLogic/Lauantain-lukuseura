<!DOCTYPE html>
<html lang="fi">
    <head>
        <title>Lauantain lukuseura - <?=$this->e($title)?></title>
        <meta charset="UTF-8">
        <link href="styles/lp_styles.css" rel="stylesheet">
    </head>
    <body>
        <header>
            <h1><a href="<?=BASEURL?>"><img src="public/styles/lauantain-lukuseura-high-resolution-logo-transparent.png"></a></h1>
            
            <div class="tapahtumat">
            <a href='tapahtumat'>Tapahtumat</a> 
            </div>
  
            <div class="lisays">
                <a href="lisaa_tapahtuma">Lisää tapahtuma</a>
            </div>

            <div class="profile">
                <?php 
                    if (isset($_SESSION['user'])) {
                        echo "<div>$_SESSION[user]</div>";
                        echo "<div><a href='logout'>Kirjaudu ulos</a></div>";
                    } else {
                        echo "<div><a href='kirjaudu'>Kirjaudu</a></div>";
                    }
                ?>
            </div>
        </header>
        <section>
            <?=$this->section('content')?>
        </section>
        <footer>
            &copy;Lenu Logic
        </footer>
    </body>
</html>