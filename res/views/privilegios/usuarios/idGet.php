<?php

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
    <?php $view->include('/@templates/userinfobar'); ?>
    <div class="titlebar-section row">
        <h1 class="titlebar-section-title col">Permisos particulares del usuario</h1>
        <a class="titlebar-section-button col-auto" title="Modificar" href="<?=siteUrl("/privilegios/usuarios/{$usuario->usuario_id}/permisos")?>">
            <span class="icon-ws-pencil"></span>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table--wide">
            <thead>
                <tr><th>ID</th>
                    <th>Keyword</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($permisosUsuario as $p) : ?>
                <tr><td><?=$p->id_permiso?></td>
                    <td class="font--italic"><?=$p->keyword?></td>
                    <td><?=$p->nombre?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="titlebar-section row">
        <h1 class="titlebar-section-title col">Perfil: <i><?=$usuario->perfil?></i></h1>
        <a class="titlebar-section-button col-auto" title="Seleccionar" href="<?=siteUrl("/privilegios/perfiles/{$usuario->perfil_id}")?>">
            <span class="icon-ws-pencil"></span>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table--wide">
            <thead>
                <tr><th>ID</th>
                    <th>Keyword</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($permisosPerfil as $p) : ?>
                <tr><td><?=$p->id_permiso?></td>
                    <td class="font--italic"><?=$p->keyword?></td>
                    <td><?=$p->nombre?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="titlebar-section row">
        <h1 class="titlebar-section-title col">Roles</h1>
    </div>
</div>
<?php
$layout->endSection();
