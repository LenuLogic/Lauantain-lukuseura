<?php $this->layout('template', ['title' => 'Unohtunut salasana']) ?>

<h1>Unohtunut salasana</h1>

<p>Tilaa sähköpostiisi salasananvaihtolinkki alla olevalla lomakkeella.</p>
<br>
<form action="" method="POST">
    <div>
        <label for="email">Sähköposti</label>
        <input id="email" type="email" name="email">
    </div>
    <div>
        <input type="submit" name="laheta" value="Lähetä">
    </div>
</form>