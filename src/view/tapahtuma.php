<?php $this->layout('template', ['title' => $tapahtuma['nimi']]);
// yhdistin kaksi erillistä php-elementtiä (ks. tapahtuma-sivu)
$start = new DateTime($tapahtuma['tap_alkaa']);
$end = new DateTime($tapahtuma['tap_loppuu']);
?>

<h1><?=$tapahtuma['nimi']?></h1>
<div><?=$tapahtuma['kuvaus']?></div>
<div>Alkaa: <?=$start->format('j.n.Y G.i')?></div>
<div>Päättyy: <?=$end->format('j.n.Y G.i')?></div>



