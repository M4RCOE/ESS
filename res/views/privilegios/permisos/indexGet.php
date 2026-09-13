<?php

use function Francerz\Http\Utils\siteUrl;

$layout = $view->loadLayout('@layouts/default');
$layout->startSection('content');
?>
<div class="container">
    <div class="titlebar row">
        <h1 class="titlebar-title col"><?=$title?></h1>
        <div class="col-auto">
            <a class="titlebar-button" title="Agregar permiso" href="<?=siteUrl("/privilegios/permisos/agregar")?>">
                <span class="icon-ws-plus-circle-fill"></span>
            </a>
            <a class="titlebar-button js-go-back" title="Regresar">
                <span class="icon-ws-arrow-back"></span>
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table--wide">
            <thead>
                <tr><th>ID</th>
                    <th>Keyword</th>
                    <th>Nombre / Descripción</th>
                    <th>Actualizado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($permisos as $permiso) : ?>
                <tr id="permiso<?=$permiso->id_permiso?>">
                    <td><?=$permiso->id_permiso?></td>
                    <td>
                        <a href="<?=siteUrl("/privilegios/permisos/{$permiso->id_permiso}")?>">
                        <i><?=$permiso->keyword?></i>
                        </a>
                    </td>
                    <td><?=$permiso->nombre?></td>
                    <td><?=$permiso->update_time?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?=$layout->endSection()?>
