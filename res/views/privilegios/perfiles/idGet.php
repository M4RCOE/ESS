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
    <script>
        $(document.documentElement).on('change', '#chkSelectAll', function() {
            $('.chkPermiso').prop('checked', this.checked);
        });
        $(document.documentElement).on('change', '.chkPermiso', function() {
            let $chkSelectAll = $('#chkSelectAll')
                .prop('checked', false)
                .prop('indeterminate', false);
            let $chkPermiso = $('.chkPermiso');
            let $checked = $('.chkPermiso:checked');
            if ($chkPermiso.length == $checked.length) {
                $chkSelectAll.prop('checked', true);
            } else if ($checked.length > 0) {
                $chkSelectAll.prop('indeterminate', true);
            }
        });
    </script>
    <form action="<?=currentUrl()?>" method="post">
        <div class="table-responsive">
            <table class="table--wide">
                <thead>
                    <tr><th class="text--center">
                            <input type="checkbox" id="chkSelectAll" />
                        </th>
                        <th>Keyword</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($permisos as $permiso) : ?>
                    <tr><td class="text--center">
                            <input type="checkbox" class="chkPermiso" name="permisos[]" id="chkPermiso<?=$permiso->id_permiso?>" value="<?=$permiso->id_permiso?>" />
                        </td>
                        <td><label for="chkPermiso<?=$permiso->id_permiso?>"><i><?=$permiso->keyword?></i></label></td>
                        <td><label for="chkPermiso<?=$permiso->id_permiso?>"><?=$permiso->nombre?></label></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <script>
                <?php foreach ($perfil->Permisos as $p) : ?>
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
