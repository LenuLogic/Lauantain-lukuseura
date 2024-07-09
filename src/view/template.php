<!DOCTYPE html>
<html lang="fi">
    <head>
        <title>Lauantain lukuseura - <?=$this->e($title)?></title>
        <meta charset="UTF-8">
        <link href="styles/styles.css" rel="stylesheet">
    </head>
    <body>
        <header>
            <h1><a href="<?=BASEURL?>">Lauantain lukuseura</a></h1>
            
            <!-- Tapahtumat -->
            <div class="tapahtumat">
            <a href="<?=BASEURL?>">Tapahtumat</a>
            </div>

            <!-- Lisää tapahtuma -->    
            <div class="lisays">

            <div class="profile">
                <?php 
                    if (isset($_SESSION['user'])) {
                        echo "<div>$_SESSION[user]</div>";
                        echo "<div><a href='logout'>Kirjaudu ulos</a></div>";
                        if (isset($_SESSION['admin']) && $_SESSION['admin']) {
                            echo "<div><a href='admin'>Ylläpitosivut</a></div>";
                        }
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