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
    <?php $view->include('/@templates/userinfobar'); ?>
    <div class="titlebar-section row">
        <h1 class="titlebar-section-title col">Seleccionar los permisos individuales para este usuario</h1>
    </div>
    <script>
        $(document.documentElement).on('change', '#chkSelectAll', function() {
            $('.chkPermiso').prop('checked', this.checked);
        });
        $(document.documentElement).on('change', '.chkPermiso', function() {
            let $chkSelectAll = $('#chkSelectAll')
                .prop('checked', false)
                .prop('indeterminate', false);
            let $chkPerfil = $('.chkPermiso');
            let $checked = $('.chkPermiso:checked');
            if ($chkPerfil.length == $checked.length) {
                $chkSelectAll.prop('checked', true);
            } else if ($checked.length > 0) {
                $chkSelectAll.prop('indeterminate', true);
            }
        });
    </script>
    <form method="post" action="<?=currentUrl()?>">
        <div class="table-responsive">
            <table class="table--wide">
                <thead>
                    <tr><th class="text--center">
                            <input type="checkbox" id="chkSelectAll" />
                        </th>
                        <th>Keyword</th>
                        <th>Permiso</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($permisos as $p) : ?>
                    <tr><td class="text--center">
                            <input type="checkbox" class="chkPermiso" name="permisos[]" id="chkPermiso<?=$p->id_permiso?>" value="<?=$p->id_permiso?>" />
                        </td>
                        <td class="font--italic"><label for="chkPermiso<?=$p->id_permiso?>"><?=$p->keyword?></label></td>
                        <td><label for="chkPermiso<?=$p->id_permiso?>"><?=$p->nombre?></label></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <script>
                <?php foreach ($permisosUsuario as $p) : ?>
                $('#chkPermiso<?=$p->id_permiso?>').prop('checked', true);
                <?php endforeach; ?>
                $('.chkPermiso:first').trigger('change');
            </script>
        </div>
        <div class="form-group row--end">
            <button type="submit" class="button--primary">Guardar cambios</button>
        </div>
    </form>
</div>
<?php
$layout->endSection();
