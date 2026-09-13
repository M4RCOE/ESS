<?php

namespace App\Models;

use Francerz\SqlBuilder\SelectQuery;
use Francerz\WebappModelUtils\ModelDescriptor;
use Francerz\WebappModelUtils\ModelParams;

/**
 * Class.........: PrivPermiso
 * Database alias: siitec_cid
 * Table.........: priv_permisos
 * Table alias...: permiso
 * Primary key...: id_permiso
 */
class PrivPermiso extends AbstractModel
{
    public $id_permiso;
    public $nombre;
    public $keyword;

    public static function getModelDescriptor(): ModelDescriptor
    {
        $modelDescriptor = new ModelDescriptor('siitec_cid', 'priv_permisos', 'permiso');
        $modelDescriptor->setPrimaryKeyNames(['id_permiso']);
        return $modelDescriptor;
    }

    public static function buildSelectQuery(SelectQuery $query, ModelParams $params): SelectQuery
    {
        if (isset($params['id_permiso'])) {
            $query->where('permiso.id_permiso', $params['id_permiso']);
        }

        if (isset($params['id_usuario'])) {
            $query->innerJoin('priv_usuarios_permisos AS pup')
                ->on('permiso.id_permiso', 'pup.id_permiso');
            $query->where('pup.id_usuario', $params['id_usuario']);
        }

        if (isset($params['id_perfil'])) {
            $query->innerJoin('priv_perfiles_permisos AS ppp')
                ->on('permiso.id_permiso', 'ppp.id_permiso');
            $query->where('ppp.id_perfil', $params['id_perfil']);
        }

        if (isset($params['roles.id_usuario'])) {
            $query->innerJoin('priv_roles_permisos AS prp')
                ->on('permiso.id_permiso', 'prp.id_permiso');
            $query->innerJoin('priv_usuarios_roles AS pur')
                ->on('prp.id_rol', 'pur.id_rol');
            $query->where('pur.id_usuario', $params['roles.id_usuario']);
        }

        return $query;
    }
}
