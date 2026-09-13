<?php

namespace App\Models;

use Francerz\SqlBuilder\SelectQuery;
use Francerz\WebappModelUtils\ModelDescriptor;
use Francerz\WebappModelUtils\ModelParams;
use ITColima\SiitecApi\Resources\App\PerfilesResource;

/**
 * Class.........: PrivPerfil
 * Database alias: siitec_cid
 * Table.........: priv_perfiles
 * Table alias...: perfil
 * Primary key...: id_perfil
 */
class PrivPerfil extends AbstractModel
{
    public $id_perfil;
    public $nombre;

    public static function getModelDescriptor(): ModelDescriptor
    {
        $modelDescriptor = new ModelDescriptor('siitec_cid', 'priv_perfiles', 'perfil');
        $modelDescriptor->setPrimaryKeyNames(['id_perfil']);
        return $modelDescriptor;
    }

    public static function buildSelectQuery(SelectQuery $query, ModelParams $params): SelectQuery
    {
        if (isset($params['id_perfil'])) {
            $query->where('perfil.id_perfil', $params['id_perfil']);
        }

        if (isset($params['id_permiso'])) {
            $query->innerJoin('priv_perfiles_permisos AS ppp')
                ->on('ppp.id_perfil', 'perfil.id_perfil');
            $query->where('ppp.id_permiso', $params['id_permiso']);
        }

        if (isset($params['not_id_permiso'])) {
            $subquery = PrivPerfilPermiso::getQuery(['id_permiso' => $params['not_id_permiso']]);
            $query->leftJoin(['ppp' => $subquery])
                ->on('ppp.id_perfil', 'perfil.id_perfil');
            $query->where()->null('ppp.id_perfil');
        }

        if (isset($params['nest_permisos'])) {
            $nestQuery = PrivPermiso::getQuery($params->getSubparams('nest_permisos'));
            $nestQuery->innerJoin('priv_perfiles_permisos AS ppp', ['id_perfil'])
                ->on('ppp.id_permiso', 'permiso.id_permiso');
            $query->nestMany('Permisos', $nestQuery, $row, PrivPermiso::class)
                ->where('ppp.id_perfil', $row->id_perfil);
        }

        return $query;
    }
}
