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
            <div class="form-group col-12 col-md-8">
                <label for="inpUsuario" class="form-label"></label>
                <div class="input-group row">
                    <input type="text" class="col" name="usuario" id="inpUsuario" value="<?=$usuario ?? ''?>" placeholder="Buscar por nombre, usuario, número de control o RFC." required />
                    <button type="submit" class="button--primary col-auto">
                        <span class="icon-ws-search"></span>
                    </button>
                </div>
            </div>
        </div>
    </form>
    <?php if (!empty($usuariosFound)) : ?>
    <div class="table-responsive">
        <table class="table--wide">
            <thead>
                <tr><th>ID</th>
                    <th>Usuario</th>
                    <th>Nombre completo</th>
                    <th>Perfil</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuariosFound as $u) : ?>
                <tr><td><a href="<?=siteUrl("/privilegios/usuarios/{$u->usuario_id}")?>"><?=$u->usuario_id?></a></td>
                    <td><?=$u->usuario?></td>
                    <td><?="{$u->nombres} {$u->apellido1} {$u->apellido2}"?></td>
                    <td><a href="<?=siteUrl("/privilegios/perfiles/{$u->perfil_id}")?>"><?=$u->perfil?></a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php elseif (!empty($usuarios)) : ?>
    <div class="table-responsive">
        <table class="table--wide">
            <thead>
                <tr><th>ID</th>
                    <th>Usuario</th>
                    <th>Nombre completo</th>
                    <th>Perfil</th>
                    <th>Permisos</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $u) : ?>
                <tr><td><a href="<?=siteUrl("/privilegios/usuarios/{$u->id_usuario}")?>"><?=$u->id_usuario?></a></td>
                    <td><?=$u->usuario?></td>
                    <td><?="{$u->nombres} {$u->apellido1} {$u->apellido2}"?></td>
                    <td><a href="<?=siteUrl("/privilegios/perfiles/{$u->id_perfil}")?>"><?=$u->Perfil->nombre?></a></td>
                    <td>
                        <?php foreach ($u->Permisos as $permiso) : ?>
                        <a class="tag-code" href="<?=siteUrl("/privilegios/permisos/{$permiso->id_permiso}")?>"><?=$permiso->keyword?></a>
                        <?php endforeach; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
<?php
$layout->endSection();
