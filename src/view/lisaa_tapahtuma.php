<?php $this->layout('template', ['title' => 'Lisää tapahtuma']) ?>

<h1>Lisää tapahtuma</h1>

<form action="" method="POST">
    <div>
        <label for="nimi">Nimi</label>
        <input id="nimi" type="text" name="nimi" value="<?= getValue($formdata, 'nimi') ?>">
        <div class="error"><?= getValue($error,'nimi'); ?></div>
    </div>
    <div>
        <label for="kuvaus">Tapahtuman kuvaus</label>
        <input id="kuvaus" type="text" name="kuvaus" value="<?= getValue($formdata, 'kuvaus') ?>">
        <div class="error"><?= getValue($error,'kuvaus'); ?></div>
    </div>    
    
    <div>
        <label for="alkaa_pvm">Alkamispäivä (vvvv-kk-pv)</label>
        <input id="alkaa_pvm" type="text" name="alkaa_pvm" value="<?= getValue($formdata, 'alkaa_pvm') ?>">
        <div class="error"><?= getValue($error,'alkaa_pvm'); ?></div>
    </div>
    
    <div>
        <label for="alkaa_klo">Alkamisaika (hh:mm)</label>
        <input id="alkaa_klo" type="text" name="alkaa_klo" value="<?= getValue($formdata, 'alkaa_klo') ?>">
        <div class="error"><?= getValue($error,'alkaa_klo'); ?></div>
    </div>    

    <div>
        <label for="loppuu_pvm">Päättymispäivä (vvvv-kk-pv)</label>
        <input id="loppuu_pvm" type="text" name="loppuu_pvm" value="<?= getValue($formdata, 'loppuu_pvm') ?>">
        <div class="error"><?= getValue($error,'loppuu_pvm'); ?></div>
    </div>

    <div>
        <label for="loppuu_klo">Päättymisaika (hh:mm)</label>
        <input id="loppuu_klo" type="text" name="loppuu_klo" value="<?= getValue($formdata, 'loppuu_klo') ?>">
        <div class="error"><?= getValue($error,'loppuu_klo'); ?></div>
    </div>

    <div>
        <input type="submit" name="laheta" value="Lisää tapahtuma">
    </div>
</form>