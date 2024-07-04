<?php $this->layout('template', ['title' => 'Tili luotu']) ?>

<h1>Sinulle on luotu uusi tili!</h1>

<p>Sinun tulee varmistaa sähköpostiosoitteesi ennen, kuin voit käyttää
tiliäsi. Sähköpostiisi (<?= getValue($formdata,'email') ?>)
on lähetetty vahvistusviesti. Ole hyvä ja käy vahvistamassa sähköpostiosoitteesi klikkaamalla
viestissä olevaa linkkiä.</p>