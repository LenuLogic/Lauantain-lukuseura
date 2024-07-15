<?php $this->layout('template', ['title' => 'Kirjautuminen']) ?>

<h1>Kirjaudu palveluun</h1>

<form action="" method="POST">
    <div>
        <label>Sähköposti</label>
        <input type="text" name="email">
    </div>
    <div>
        <label>Salasana</label>
        <input type="password" name="salasana">
    </div>
    <div class="error"><?= getValue($error, 'virhe'); ?></div>
    <div>
        <input type="submit" name="laheta" value="Kirjaudu">
    </div>
</form>
<br>
<div class="info"><em>Jos sinulla ei ole vielä tunnuksia, voit luoda ne <a href="lisaa_tili">täällä</a>.<br>
Jos olet unohtanut salasanasi, voit vaihtaa sen <a href="tilaa_vaihtoavain">täällä</a></em>.
</div> 