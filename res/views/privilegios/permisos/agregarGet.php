<?php

use function Francerz\Http\Utils\currentUrl;
use function Francerz\Http\Utils\siteUrl;

$layout = $view->loadLayout('@layouts/default');
$layout->startSection('content');
?>
<div class="container">
    <div class="titlebar row">
        <h1 class="titlebar-title col"><?=$title?></h1>
        <div class="col-auto">
            <a class="titlebar-button js-go-back" title="Regresar">
                <span class="icon-ws-arrow-back"></span>
            </a>
        </div>
    </div>
    <form action="<?=currentUrl()?>" method="post" class="form">
        <div class="row">
            <div class="form-group col-3">
                <label for="inpKeyword" class="form-label">Keyword:</label>
                <input type="text" name="keyword" id="inpKeyword" maxlength="28" placeholder="Ej.: admin-catalogos.sync" required autofocus />
                <div class="input-hint">Formato: <code>&lt;ámbito&gt;-&lt;objeto&gt;.&lt;acción&gt;</code></div>
            </div>
            <div class="form-group col">
                <label for="inpNombre" class="form-label">Nombre / Descripción del permiso:</label>
                <input type="text" name="nombre" id="inpNombre" required />
            </div>
        </div>
        <div class="row--end">
            <div class="form-group col--auto">
                <button type="submit" class="button--primary">Agregar permiso</button>
            </div>
        </div>
    </form>
</div>
<?php
$layout->endSection();
