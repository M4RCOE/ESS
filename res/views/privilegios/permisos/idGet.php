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
    <form method="post" action="<?=siteUrl("/privilegios/permisos/{$permiso->id_permiso}/modificar")?>" class="form">
        <div class="row">
            <div class="form-group col-3">
                <label for="txtKeyword" class="form-label">Keyword:</label>
                <input type="text" class="font--italic" name="keyword" id="txtKeyword" maxlength="28" value="<?=$permiso->keyword?>" required readonly />
            </div>
            <div class="form-group col-9">
                <label for="txtNombre" class="form-label">Nombre / Descripción:</label>
                <input type="text" name="nombre" id="txtNombre" value="<?=$permiso->nombre?>" required autofocus />
            </div>
        </div>
        <div class="row--end">
            <button type="submit" class="button--primary">Actualizar</button>
        </div>
    </form>
    <div class="titlebar-section row" id="perfiles">
        <h1 class="titlebar-section-title col">Perfiles</h1>
        <a class="titlebar-section-button col-auto" title="Agregar" href="<?=siteUrl("/privilegios/permisos/{$permiso->id_permiso}/perfiles/seleccionar")?>">
            <span class="icon-ws-plus-circle-fill"></span>
        </a>
    </div>
    <script>
        $(document.documentElement).on('click', '.ajax-post-link', function(e) {
            e.preventDefault();
            let $this = $(this);
            let $tr = $this.closest('tr');
            $.ajax({
                'type': 'POST',
                'url': $this.prop('href'),
                'success': function (data) {
                    $tr.prop('style', 'opacity:0.2');
                },
                'error': function() {
                    $tr.addClass('bg-red');
                }
            })
        });
    </script>
    <div class="table-responsive">
        <table class="table--wide">
            <thead>
                <tr><th>ID</th>
                    <th>Nombre</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($perfiles as $perfil) : ?>
                <tr id="perfil<?=$perfil->id_perfil?>">
                    <td><?=$perfil->id_perfil?></td>
                    <td><?=$perfil->nombre?></td>
                    <td>
                        <a class="button-square--red ajax-post-link"
                            href="<?=siteUrl("/privilegios/permisos/{$permiso->id_permiso}/perfiles/{$perfil->id_perfil}/quitar")?>">
                            <span class="icon-ws-x-circle-fill"></span>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php if (false) : ?>
    <div class="titlebar-section row" id="roles">
        <h1 class="titlebar-section-title col">Roles</h1>
        <a class="titlebar-section-button col-auto" title="Agregar" href="#">
            <span class="icon-ws-plus-circle-fill"></span>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table--wide">
            <thead>
                <tr><th>Nombre</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($roles as $rol) : ?>
                <tr><td><?=$rol->nombre?></td>
                    <td></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
    <div class="titlebar-section row" id="usuarios">
        <h1 class="titlebar-section-title col">Usuarios</h1>
        <a class="titlebar-section-button col-auto" title="Agregar" href="<?=siteUrl("/privilegios/permisos/{$permiso->id_permiso}/usuarios")?>">
            <span class="icon-ws-plus-circle-fill"></span>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table--wide">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Nombre propio</th>
                    <th>Tipo de usuario</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario) : ?>
                <tr>
                    <td><?=$usuario->id_usuario?></td>
                    <td><?=$usuario->usuario?></td>
                    <td><?="{$usuario->nombres} {$usuario->apellido1} {$usuario->apellido2}"?></td>
                    <td><?=$usuario->tipo_usuario?></td>
                    <td>
                        <a class="button-square--red ajax-post-link"
                            href="<?=siteUrl("/privilegios/permisos/{$permiso->id_permiso}/usuarios/{$usuario->id_usuario}/quitar")?>">
                            <span class="icon-ws-x-circle-fill"></span>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?=$layout->endSection()?>
