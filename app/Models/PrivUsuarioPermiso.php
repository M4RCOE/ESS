<?php

namespace App\Models;

use Francerz\PowerData\Matrix;
use Francerz\SqlBuilder\DatabaseManager;
use Francerz\SqlBuilder\Query;
use Francerz\SqlBuilder\SelectQuery;
use Francerz\WebappModelUtils\ModelDescriptor;
use Francerz\WebappModelUtils\ModelParams;
use Throwable;

/**
 * Class.........: PrivUsuarioPermiso
 * Database alias: siitec_cid
 * Table.........: priv_usuarios_permisos
 * Table alias...: pup
 * Primary key...: id_usuario
 */
class PrivUsuarioPermiso extends AbstractModel
{
    public $id_usuario;
    public $id_permiso;

    public static function getModelDescriptor(): ModelDescriptor
    {
        $modelDescriptor = new ModelDescriptor('siitec_cid', 'priv_usuarios_permisos', 'pup');
        $modelDescriptor = $modelDescriptor->withPrimaryKeyNames(['id_usuario', 'id_permiso']);
        return $modelDescriptor;
    }

    public static function buildSelectQuery(SelectQuery $query, ModelParams $params): SelectQuery
    {
        if (isset($params['id_usuario'])) {
            $query->where('pup.id_usuario', $params['id_usuario']);
        }
        if (isset($params['id_permiso'])) {
            $query->where('pup.id_permiso', $params['id_permiso']);
        }

        return $query;
    }

    public static function setPermisos($idUsuario, array $idPermisoArray)
    {
        $rows = Matrix::transpose([
            'id_usuario' => array_fill(0, count($idPermisoArray), $idUsuario),
            'id_permiso' => $idPermisoArray
        ]);

        $modelDescriptor = static::getModelDescriptorCached();
        $db = DatabaseManager::connect($modelDescriptor->getDatabase());
        $db->startTransaction();
        try {
            if (!empty($idPermisoArray)) {
                $query = Query::upsert($modelDescriptor->getTableName(), $rows, ['id_usuario', 'id_permiso'], []);
                $db->executeUpsert($query);
            }

            $query = Query::deleteFrom($modelDescriptor->getTableName());
            $query->where('id_usuario', $idUsuario);
            if (!empty($idPermisoArray)) {
                $query->where()->notIn('id_permiso', $idPermisoArray);
            }
            $db->executeDelete($query);

            $db->commit();
        } catch (Throwable $ex) {
            $db->rollback();
            throw $ex;
        }
    }
}
