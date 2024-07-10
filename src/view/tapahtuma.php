<?php $this->layout('template', ['title' => $tapahtuma['nimi']]);

$alkupvm = new DateTime($tapahtuma['alkaa_pvm']); 
$alkuklo = new DateTime($tapahtuma['alkaa_klo']);
$loppupvm = new DateTime($tapahtuma['loppuu_pvm']);
$loppuklo = new DateTime($tapahtuma['loppuu_klo']);
?>

<h1><?=$tapahtuma['nimi']?></h1>
<div><?=$tapahtuma['kuvaus']?></div><br>
<div>Alkaa: <?=$alkupvm->format('j.n.Y') . " klo " . $alkuklo->format('G.i') ?></div> 
<div>Päättyy: <?=$loppupvm->format('j.n.Y') . " klo " . $loppuklo->format('G.i') ?></div> <!-- Muuta tämä -->

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



