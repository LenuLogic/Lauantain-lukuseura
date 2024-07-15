<?php $this->layout('template', ['title' => 'Tulevat tapahtumat']) ?>

<h1>Tulevat tapahtumat</h1>

<div class='tapahtumat'>
<?php
foreach ($tapahtumat as $tapahtuma) {
    $alkupvm = new DateTime($tapahtuma['alkaa_pvm']); 
    $alkuklo = new DateTime($tapahtuma['alkaa_klo']);
    $loppupvm = new DateTime($tapahtuma['loppuu_pvm']);
    $loppuklo = new DateTime($tapahtuma['loppuu_klo']);

    echo "<div>";
        echo "<div class='tap_nimi'>$tapahtuma[nimi]</div>";
        echo "<div>Alkaa <em>" . $alkupvm->format('j.n.Y') . " klo " . $alkuklo->format('G.i') . "</em></div>";
        echo "<div>Päättyy <em>" . $loppupvm->format('j.n.Y') . " klo " . $loppuklo->format('G.i') . "</em></div>";
        echo "<div><a href='tapahtuma?id=" . $tapahtuma['idtapahtuma'] . "'>TIEDOT</a></div><br>";
    echo "</div>";
}

?>
</div>