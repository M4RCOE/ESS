<?php

namespace App\Models;

use Francerz\PowerData\Index;
use Francerz\PowerData\Matrix;
use Francerz\SqlBuilder\DatabaseManager;
use Francerz\SqlBuilder\Query;
use Francerz\SqlBuilder\Results\DeleteResult;
use Francerz\SqlBuilder\SelectQuery;
use Francerz\WebappModelUtils\ModelDescriptor;
use Francerz\WebappModelUtils\ModelParams;
use Throwable;

/**
 * Class.........: PrivPerfilPermiso
 * Database alias: siitec_cid
 * Table.........: priv_perfiles_permisos
 * Table alias...: ppp
 * Primary key...: id_perfil, id_permiso
 */
class PrivPerfilPermiso extends AbstractModel
{
    public $id_perfil;
    public $id_permiso;

    public static function getModelDescriptor(): ModelDescriptor
    {
        $modelDescriptor = new ModelDescriptor('siitec_cid', 'priv_perfiles_permisos', 'ppp');
        $modelDescriptor->setPrimaryKeyNames(['id_perfil', 'id_permiso']);
        return $modelDescriptor;
    }

    public static function buildSelectQuery(SelectQuery $query, ModelParams $params): SelectQuery
    {
        if (isset($params['id_perfil'])) {
            $query->where('ppp.id_perfil', $params['id_perfil']);
        }

        if (isset($params['id_permiso'])) {
            $query->where('ppp.id_permiso', $params['id_permiso']);
        }

        return $query;
    }

    public static function setPermisos($idPerfil, array $idPermisoArray)
    {
        $rows = Matrix::transpose([
            'id_perfil' => array_fill(0, count($idPermisoArray), $idPerfil),
            'id_permiso' => $idPermisoArray
        ]);

        $modelDescriptor = static::getModelDescriptorCached();
        $db = DatabaseManager::connect($modelDescriptor->getDatabase());
        $db->startTransaction();
        try {
            if (!empty($idPermisoArray)) {
                $query = Query::upsert($modelDescriptor->getTableName(), $rows, ['id_perfil', 'id_permiso'], []);
                $db->executeUpsert($query);
            }

            $query = Query::deleteFrom($modelDescriptor->getTableName());
            $query->where('id_perfil', $idPerfil);
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
