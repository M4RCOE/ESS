<?php

namespace App\Models;

use Francerz\SqlBuilder\SelectQuery;
use Francerz\WebappModelUtils\ModelDescriptor;
use Francerz\WebappModelUtils\ModelParams;

/**
 * Class.........: PrivRol
 * Database alias: siitec_cid
 * Table.........: priv_roles
 * Table alias...: pr
 * Primary key...: id_rol
 */
class PrivRol extends AbstractModel
{
    public $id_rol;
    public $nombre;

    public static function getModelDescriptor(): ModelDescriptor
    {
        $modelDescriptor = new ModelDescriptor('siitec_cid', 'priv_roles', 'pr');
        $modelDescriptor->setPrimaryKeyNames(['id_rol']);
        return $modelDescriptor;
    }

    public static function buildSelectQuery(SelectQuery $query, ModelParams $params): SelectQuery
    {
        if (isset($params['id_rol'])) {
            $query->where('pr.id_rol', $params['id_rol']);
        }

        if (isset($params['id_permiso'])) {
            $query->innerJoin('priv_roles_permisos as prp')
                ->on('prp.id_rol', 'pr.id_rol');
            $query->where('prp.id_permiso', $params['id_permiso']);
        }

        return $query;
    }
}
