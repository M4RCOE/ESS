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
    <form action="<?=currentUrl()?>" method="get" class="form">
        <div class="row">
            <div class="form-group col-12 col-md-8 col-lg-6">
                <label for="txtUsuario" class="label">Búsqueda de usuario:</label>
                <div class="input-group row--nowrap">
                    <input class="col" type="text" name="usuario" id="txtUsuario" value="<?=$usuario ?? ''?>" required autofocus />
                    <button class="button--primary col-auto" type="submit" tabindex="-1">
                        <span class="icon-ws-search"></span>
                    </button>
                </div>
            </div>
        </div>
    </form>
    <?php if (!empty($usuarios)) : ?>
    <div class="titlebar-section row">
        <h1 class="titlebar-section-title col">Seleccionar usuario</h1>
    </div>
    <form action="<?=currentUrl()?>" method="post" class="form">
        <div class="table-responsive">
            <table class="table--wide">
                <thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Nombre de usuario</th>
                        <th>Nombre propio</th>
                        <th>Tipo usuario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $u) : ?>
                    <tr><td>
                            <input type="radio" name="usuario" id="rdbUsuario<?=$u->usuario_id?>" value="<?=$u->usuario_id?>" required />
                        </td>
                        <td><label for="rdbUsuario<?=$u->usuario_id?>"><?=$u->usuario_id?></label></td>
                        <td><label for="rdbUsuario<?=$u->usuario_id?>"><?=$u->usuario?></label></td>
                        <td><label for="rdbUsuario<?=$u->usuario_id?>"><?="{$u->nombres} {$u->apellido1} {$u->apellido2}"?></label></td>
                        <td><label for="rdbUsuario<?=$u->usuario_id?>"><?=$u->tipo_usuario?></label></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <br>
        <div class="row">
            <div class="col"></div>
            <div class="col-auto">
                <button type="submit" class="button--primary">Asociar permiso</button>
            </div>
        </div>
    </form>
    <?php endif; ?>
</div>
<?php
$layout->endSection();
