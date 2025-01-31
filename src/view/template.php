<!DOCTYPE html>
<html lang="fi">
    <head>
        <title><?=$this->e($title)?></title>
        <link rel="icon" type="image/x-icon" href="public/images/lp_logo_transparent.png">
        <meta charset="UTF-8">
        <link href="styles/lp_styles.css" rel="stylesheet">
    </head>
    <body>
        <header>
            <a href="<?=BASEURL?>"><img src="public/images/lauantain-lukuseura-high-resolution-logo-transparent.png"></a>
            
            <div class="head_otsikot">
            <div class="tapahtumat">
            <a href='tapahtumat'>Tapahtumat</a> 
            </div>
  
            <div class="lisays">
                <a href="lisaa_tapahtuma">Lisää tapahtuma</a>
            </div>

            <div class="profile">
                <?php 
                    if (isset($_SESSION['user'])) {
                        echo "<div><a href='logout'>Kirjaudu ulos</a></div>";
                        echo "<div class='user'>$_SESSION[user]</div>";
                    } else {
                        echo "<div><a href='kirjaudu'>Kirjaudu</a></div>";
                    }
                ?>
            </div>
            </div>
        </header>
        <section>
            <?=$this->section('content')?>
        </section>
        <footer>
            &copy;LenuLogic
        </footer>
    </body>
</html>