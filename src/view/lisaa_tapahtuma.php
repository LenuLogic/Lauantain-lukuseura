<?php $this->layout('template', ['title' => 'Lisää tapahtuma']) ?>

<h1>Lisää tapahtuma</h1>

<form action="" method="POST">
    <div>
        <label for="nimi">Nimi</label>
        <input id="nimi" type="text" name="nimi">
    </div>
    <div>
        <label for="kuvaus">Tapahtuman kuvaus</label>
        <input id="kuvaus" type="text" name="kuvaus">
    </div>    
    <div>
        <label for="alkaa_pvm">Alkamispäivä (vvvv-kk-pv)</label>
        <input id="alkaa_pvm" type="text" name="alkaa_pvm">
    </div>
    <div>
        <label for="alkaa_klo">Alkamisaika (hh:mm)</label>
        <input id="alkaa_klo" type="text" name="alkaa_klo">
    </div>    
    <div>
        <label for="loppuu_pvm">Päättymispäivä (vvvv-kk-pv)</label>
        <input id="loppuu_pvm" type="text" name="loppuu_pvm">
    </div>
    <div>
        <label for="loppuu_klo">Päättymisaika (hh:mm)</label>
        <input id="loppuu_klo" type="text" name="loppuu_klo">
    </div>
    <div>
        <input type="submit" name="laheta" value="Lisää tapahtuma">
    </div>
</form>