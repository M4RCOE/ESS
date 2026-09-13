<?php

namespace App\Models;

use Francerz\SqlBuilder\SelectQuery;
use Francerz\WebappModelUtils\ModelDescriptor;
use Francerz\WebappModelUtils\ModelParams;

/**
 * Class.........: Usuario
 * Database alias: cartuchos
 * Table.........: usuarios
 * Table alias...: u
 * Primary key...: id_usuario
 * 
 * @property-read mixed $perfil
 */
class Usuario extends AbstractModel
{
    public $id_usuario;
    public $id_perfil;
    public $nombres;
    public $apellido1;
    public $apellido2;
    public $usuario;
    public $contrasena;
    public $estatus;
    public function __get($name)
    {
        switch ($name) {
            case 'nombre_completo':
                return
                    $this->nombres .
                    (isset($this->apellido1) ? " {$this->apellido1}" : '') .
                    (isset($this->apellido2) ? " {$this->apellido2}" : '');
        }
    }
    public static function getModelDescriptor(): ModelDescriptor
    {
        $modelDescriptor = new ModelDescriptor('ess', 'usuarios', 'u');
        $modelDescriptor = $modelDescriptor->withPrimaryKeyNames(['id_usuario']);
        return $modelDescriptor;
    }

    public static function buildSelectQuery(SelectQuery $query, ModelParams $params): SelectQuery
    {
        $query->leftJoin(['pp' => 'priv_perfiles'], ['perfil' => 'pp.nombre'])
            ->on('pp.id_perfil', 'u.id_perfil');
        if (isset($params['id_usuario'])) {
            $query->where('u.id_usuario', $params['id_usuario']);
        }
        if (isset($params['usuario'])) {
            $query->where('LOWER(u.usuario)', strtolower($params['usuario']));
        }
        if (isset($params['contrasena'])) {
            $query->where('u.contrasena', $params['contrasena']);
            $query->where('u.estatus', 1);
        }
        if (isset($params['nombre'])) {
            $query->where('u.contrasena', $params['contrasena']);
        }
        if (isset($params['estatus'])) {
            $query->where('u.estatus', $params['estatus']);
        }
        if (isset($params['is_not_id_usuario']) && !is_null($params['is_not_id_usuario'])) {
            $query->where()->notEquals('u.id_usuario', $params['is_not_id_usuario']);
        }

        if (isset($params['id_permiso'])) {
            $query->innerJoin('priv_usuarios_permisos AS pup')
                ->on('pup.id_usuario', 'u.id_usuario');
            $query->where('pup.id_permiso', $params['id_permiso']);
        }

        if (!empty($params['has_permisos'])) {
            $query->innerJoin('priv_usuarios_permisos AS pup')
                ->on('pup.id_usuario', 'u.id_usuario');
            $query->groupBy('u.id_usuario');
        }

        if (isset($params['link_perfil'])) {
            $nestQuery = PrivPerfil::getQuery($params->getSubparams('link_perfil'));
            $query
                ->linkFirst('Perfil', $nestQuery, $row, PrivPerfil::class)
                ->where('perfil.id_perfil', $row->id_perfil);
        }

        if (isset($params['nest_permisos'])) {
            $nestQuery = PrivPermiso::getQuery($params->getSubparams('nest_permisos'));
            $nestQuery->innerJoin('priv_usuarios_permisos AS pup', ['id_usuario'])
                ->on('pup.id_permiso', 'permiso.id_permiso');
            $query
                ->nestMany('Permisos', $nestQuery, $row, PrivPermiso::class)
                ->where('pup.id_usuario', $row->id_usuario);
        }

        if (isset($params['nest_roles'])) {
            $nestQuery = PrivRol::getQuery($params->getSubparams('nest_roles'));
            $query
                ->nestMany('Roles', $nestQuery, $row, PrivRol::class)
                ->where('pr.id_rol', $row->id_rol);
        }
        if (isset($params['like_nombre'])) {
            $termino = $params['like_nombre'];
            $terminos = explode(' ', $termino);
            foreach ($terminos as $palabra) {
                $query->where(function ($group) use ($palabra) {
                    $group->orLike('nombres', "%$palabra%")
                        ->orLike('apellido1', "%$palabra%")
                        ->orLike('apellido2', "%$palabra%")
                        ->orLike('usuario', "%$palabra%");
                });
            }
        }
        if (isset($params['order_by'])) {
            $query->orderBy($params['order_by']);
        }
        return $query;
    }
    public static function duplicado($user, $id_usuario = null)
    {
        $consulta = Usuario::getFirst(['usuario' => $user, 'is_not_id_usuario' => $id_usuario]);
        if (!is_null($consulta)) {
            return true;
        }
        return false;
    }
}
