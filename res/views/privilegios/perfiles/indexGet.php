<?php

use function Francerz\Http\Utils\siteUrl;

$layout = $view->loadLayout('@layouts/default');
$layout->startSection('content');
?>
<div class="container">
    <div class="titlebar row">
        <h1 class="titlebar-title col"><?=$title?></h1>
        <div class="col-auto">
            <a href="<?=siteUrl('/privilegios/perfiles/sincronizar')?>" class="titlebar-button post-link" title="Sincronizar">
                <span class="icon-ws-refresh"></span>
            </a>
            <a class="titlebar-button js-go-back" title="Regresar">
                <span class="icon-ws-arrow-back"></span>
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table--wide">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Perfil</th>
                    <th>Permisos asignados</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($perfiles as $perfil) : ?>
                <tr class="row-perfil clickable" data-perfil="<?=$perfil->id_perfil?>">
                    <td><a href="<?=siteUrl("/privilegios/perfiles/{$perfil->id_perfil}")?>"><?=$perfil->id_perfil?></a></td>
                    <td><?=$perfil->nombre?></td>
                    <td><?php foreach ($perfil->Permisos as $permiso) : ?>
                        <a class="tag-code" href="<?=siteUrl("/privilegios/permisos/{$permiso->id_permiso}")?>"><?=$permiso->keyword?></a>
                        <?php endforeach; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
$layout->endSection();
