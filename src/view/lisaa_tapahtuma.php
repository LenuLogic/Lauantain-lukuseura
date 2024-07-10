<?php $this->layout('template', ['title' => 'Lisää tapahtuma']) ?>

<h1>Lisää oma tapahtuma</h1>

<form action="" method="POST">
    <div>
        <label for="nimi">Nimi</label>
        <input id="nimi" type="text" name="nimi" value="<?= getValue($formdata, 'nimi') ?>">
        <div class="error"><?= getValue($error,'nimi'); ?></div>
    </div>
    <div>
        <label for="email">Sähköposti</label>
        <input id="email" type="email" name="email" value="<?= getValue($formdata, 'email') ?>">
        <div class="error"><?= getValue($error, 'email'); ?></div>
    </div>
    <div>
        <label for="salasana1">Salasana</label>
        <input type="password" name="salasana1">
        <div class="error"><?= getValue($error, 'salasana'); ?></div>
    </div>
    <div>
        <label for="salasana2">Salasana uudelleen</label>
        <input type="password" name="salasana2">
    </div>
    <div>
        <input type="submit" name="laheta" value="Luo tili">
    </div>
</form>