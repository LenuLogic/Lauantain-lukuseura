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
        echo "<div>$tapahtuma[nimi]</div>";
        //echo "<div>" . $start->format('j.n.Y') . "-" . $end->format('j.n.Y') . "</div>"; // Muuta tämä
        echo "<div>Alkaa " . $alkupvm->format('j.n.Y') . " klo " . $alkuklo->format('G.i') . "</div>";
        echo "<div>Päättyy " . $loppupvm->format('j.n.Y') . " klo " . $loppuklo->format('G.i') . "</div>";
        echo "<div><a href='tapahtuma?id=" . $tapahtuma['idtapahtuma'] . "'>TIEDOT</a></div>";
    echo "</div>";
}

?>
</div>