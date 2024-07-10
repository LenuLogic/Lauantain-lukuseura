<?php $this->layout('template', ['title' => $tapahtuma['nimi']]);

$start = new DateTime($tapahtuma['tap_alkaa']); // Muuta tämä
$end = new DateTime($tapahtuma['tap_loppuu']); // Muuta tämä
?>

<h1><?=$tapahtuma['nimi']?></h1>
<div><?=$tapahtuma['kuvaus']?></div>
<div>Alkaa: <?=$start->format('j.n.Y G.i')?></div> <!-- Muuta tämä -->
<div>Päättyy: <?=$end->format('j.n.Y G.i')?></div> <!-- Muuta tämä -->

<?php
    if ($loggeduser) {
        if (!$ilmoittautuminen) {
            echo "<div class='flexarea'><a href='ilmoittaudu?id=$tapahtuma[idtapahtuma]' class='button'>ILMOITTAUDU</a></div>";
        } else {
            echo "<div class='flexarea'>";
            echo "<div>Olet ilmoittautunut tapahtumaan!</div>";
            echo"<a href='peru?id=$tapahtuma[idtapahtuma]' class='button'>PERU ILMOITTAUTUMINEN</a>";
            echo "</div>";
        }
    }
?>



