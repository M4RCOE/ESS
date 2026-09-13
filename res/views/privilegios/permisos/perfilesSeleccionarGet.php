<?php

use function Francerz\Http\Utils\currentUrl;

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
            $('.chkPerfil').prop('checked', this.checked);
        });
        $(document.documentElement).on('change', '.chkPerfil', function() {
            let $chkSelectAll = $('#chkSelectAll')
                .prop('checked', false)
                .prop('indeterminate', false);
            let $chkPerfil = $('.chkPerfil');
            let $checked = $('.chkPerfil:checked');
            if ($chkPerfil.length == $checked.length) {
                $chkSelectAll.prop('checked', true);
            } else if ($checked.length > 0) {
                $chkSelectAll.prop('indeterminate', true);
            }
        })
    </script>
    <form method="post" action="<?=currentUrl()?>">
        <div class="table-responsive">
            <table class="table--wide">
                <thead>
                    <tr>
                        <th class="text--center"><input type="checkbox" name="" id="chkSelectAll"></th>
                        <th>Perfil</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($perfiles as $perfil) : ?>
                    <tr><td class="text--center">
                            <input type="checkbox" class="chkPerfil" name="perfiles[]" id="chkPerfil<?=$perfil->id_perfil?>" value="<?=$perfil->id_perfil?>">
                        </td>
                        <td><label for="chkPerfil<?=$perfil->id_perfil?>"><?=$perfil->nombre?></label></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="form-group row--end">
            <button type="submit" class="button--primary">Guardar cambios</button>
        </div>
    </form>
</div>
<?=$layout->endSection()?>
