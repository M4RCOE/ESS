<?php

namespace App\Controllers;

use App\Application;
use App\Classes\MenuItem;
use App\Models\PrivPerfil;
use App\Models\PrivPerfilPermiso;
use App\Models\PrivPermiso;
use App\Models\PrivRol;
use App\Models\PrivUsuarioPermiso;
use App\Models\Usuario;
use Psr\Http\Message\ResponseInterface as IResponse;
use Psr\Http\Message\ServerRequestInterface as IServerRequest;

use function Francerz\Http\Utils\siteUrl;

class PrivilegiosController extends AbstractController
{
    private const PERFILES_PRIORITARIOS = [1,2];

    public function indexGet(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        $menuItems[] = new MenuItem(
            'Permisos',
            siteUrl('/privilegios/permisos'),
            'Acciones que puede realizarse en el sistema.',
            'icon-ws-tag'
        );
        $menuItems[] = new MenuItem(
            'Usuarios',
            siteUrl('/privilegios/usuarios'),
            'Gestionar los permisos asignados por usuario específico',
            'icon-ws-contact'
        );
        $menuItems[] = new MenuItem(
            'Perfiles',
            siteUrl('/privilegios/perfiles'),
            'Gestionar los perfiles de acceso al sistema',
            'icon-ws-people'
        );
        // $menuItems[] = new MenuItem(
        //     'Roles',
        //     siteUrl('/privilegios/roles'),
        //     'Roles',
        //     'icon-ws-grid'
        // );
        return Application::getRenderer()->renderView('home/indexGet', [
            'title' => 'Adminsitración de privilegios',
            'menuItems' => $menuItems
        ]);
        return $response;
    }

    public function permisosGet(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        $permisos = PrivPermiso::getRows(['@orderBy' => 'keyword']);
        return Application::getRenderer()->renderView('/privilegios/permisos/indexGet', [
            'title' => 'Permisos',
            'permisos' => $permisos
        ]);
    }

    public function permisosAgregarGet(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        return Application::getRenderer()->renderView('/privilegios/permisos/agregarGet', [
            'title' => 'Agregar Permiso',
        ]);
    }

    public function permisosAgregarPost(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        $post = $request->getParsedBody();
        $permiso = new PrivPermiso();
        $permiso->nombre = $post['nombre'];
        $permiso->keyword = $post['keyword'];
        PrivPermiso::insert($permiso, ['nombre', 'keyword']);
        return Application::getRenderer()->renderRedirect(siteUrl("/privilegios/permisos#permiso{$permiso->id_permiso}"));
    }

    public function permisosIdGet(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        $id_permiso = $params['id'];
        $permiso = PrivPermiso::getFirst(['id_permiso' => $id_permiso]);
        $perfiles = PrivPerfil::getRows(['id_permiso' => $id_permiso, '@orderBy' => 'nombre']);
        $roles = PrivRol::getRows(['id_permiso' => $id_permiso, '@orderBy' => 'nombre']);
        $usuarios = Usuario::getRows(['id_permiso' => $id_permiso, '@orderBy' => ['nombres', 'apellido1', 'apellido2']]);
        return Application::getRenderer()->renderView('/privilegios/permisos/idGet', [
            'title' => "Permiso <code>{$permiso->keyword}</code>",
            'permiso' => $permiso,
            'perfiles' => $perfiles,
            'roles' => $roles,
            'usuarios' => $usuarios
        ]);
    }

    public function permisosIdModificarPost(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        $post = $request->getParsedBody();

        $id_permiso = $params['id'];
        $permiso = PrivPermiso::getFirst(['id_permiso' => $id_permiso]);
        $permiso->nombre = $post['nombre'];
        PrivPermiso::update($permiso, ['id_permiso'], ['nombre']);

        return Application::getRenderer()->renderRedirect(siteUrl("/privilegios/permisos#permiso{$id_permiso}"));
    }

    public function permisosPerfilesSeleccionarGet(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        $id_permiso = $params['id'];
        $permiso = PrivPermiso::getFirst(['id_permiso' => $id_permiso]);
        $perfiles = PrivPerfil::getRows(['@orderBy' => 'nombre', 'not_id_permiso' => $id_permiso]);
        return Application::getRenderer()->renderView('/privilegios/permisos/perfilesSeleccionarGet', [
            'title' => "Asociar perfiles a <code>{$permiso->keyword}</code>",
            'permiso' => $permiso,
            'perfiles' => $perfiles
        ]);
    }

    public function permisosPerfilesSeleccionarPost(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        $id_permiso = $params['id'];

        $post = $request->getParsedBody();
        $idPerfilArray = $post['perfiles'] ?? [];

        $perfilesPermisos = [];
        foreach ($idPerfilArray as $id_perfil) {
            $perfilesPermisos[] = $perfilPermiso = new PrivPerfilPermiso();
            $perfilPermiso->id_perfil = $id_perfil;
            $perfilPermiso->id_permiso = $id_permiso;
        }
        PrivPerfilPermiso::upsertMany($perfilesPermisos, ['id_perfil', 'id_permiso'], []);

        return Application::getRenderer()->renderRedirect(siteUrl("/privilegios/permisos/{$id_permiso}#perfiles"));
    }

    public function permisosPerfilQuitarPost(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        $id_permiso = $params['id'];
        $id_perfil = $params['per'];

        if ($id_permiso == 1 && in_array($id_perfil, self::PERFILES_PRIORITARIOS)) {
            return Application::getRenderer()->renderJson([
                'status' => '400',
                'error_message' => "No se puede borrar la asignación de permisos al perfil con ID {$id_perfil}."
            ])->withStatus(400);
        }
        PrivPerfilPermiso::delete(['id_permiso' => $id_permiso, 'id_perfil' => $id_perfil]);

        return Application::getRenderer()->renderJson([
            'status' => 200,
            'message' => "Perfil con ID {$id_perfil} eliminado."
        ]);
    }

    public function permisosUsuariosGet(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        $id_permiso = $params['id'];
        $permiso = PrivPermiso::getFirst(['id_permiso' => $id_permiso]);
        $viewData = [
            'title' => "Permitir <code>{$permiso->keyword}</code>`",
        ];
        $get = $request->getQueryParams();
        if (!empty($get['usuario'])) {
            $usuario = $viewData['usuario'] = $get['usuario'];
        }
        return Application::getRenderer()->renderView('/privilegios/permisos/usuariosBuscarGet', $viewData);
    }

    public function permisosUsuariosPost(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        $id_permiso = $params['id'];
        $post = $request->getParsedBody();
        $id_usuario = $post['usuario'];
        $usuarioPermiso = new PrivUsuarioPermiso();
        $usuarioPermiso->id_usuario = $id_usuario;
        $usuarioPermiso->id_permiso = $id_permiso;
        PrivUsuarioPermiso::upsert($usuarioPermiso, ['id_usuario', 'id_permiso']);
        return Application::getRenderer()->renderRedirect(siteUrl("/privilegios/permisos/{$id_permiso}#usuario{$id_usuario}"));
    }

    public function permisosUsuarioQuitarPost(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        $id_permiso = $params['id'];
        $id_usuario = $params['usu'];

        PrivUsuarioPermiso::delete(['id_permiso' => $id_permiso, 'id_usuario' => $id_usuario]);

        return Application::getRenderer()->renderJson([
            'status' => 200,
            'message' => "Se quitó el permiso {$id_permiso} al usuario {$id_usuario}."
        ]);
    }

    public function perfilesGet(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        $perfiles = PrivPerfil::getRows([
            'nest_permisos' => ['@orderBy' => 'nombre'],
            '@orderBy' => 'nombre'
        ]);
        return Application::getRenderer()->renderView('/privilegios/perfiles/indexGet', [
            'title' => 'Perfiles',
            'perfiles' => $perfiles
        ]);
        return Application::getRenderer()->renderJson($perfiles);
    }

    public function perfilesSincronizarGet(): IResponse
    {
        return Application::getRenderer()->renderRedirect(siteUrl('/privilegios/perfiles'));
    }

    public function perfilesIdGet(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        $id_perfil = $params['id'];
        $perfil = PrivPerfil::getFirst(['id_perfil' => $id_perfil, 'nest_permisos' => true]);
        $permisos = PrivPermiso::getRows();
        return Application::getRenderer()->renderView('/privilegios/perfiles/idGet', [
            'title' => "Perfil: <code>{$perfil->nombre}</code>",
            'perfil' => $perfil,
            'permisos' => $permisos
        ]);
    }

    public function perfilesIdPost(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        $id_perfil = $params['id'];
        $post = $request->getParsedBody();
        $permisos = $post['permisos'] ?? [];

        if (!in_array(1, $permisos) && in_array($id_perfil, self::PERFILES_PRIORITARIOS)) {
            $permisos[] = 1;
        }
        PrivPerfilPermiso::setPermisos($id_perfil, $permisos);
        return Application::getRenderer()->renderRedirect(siteUrl("/privilegios/perfiles#perfil{$id_perfil}"));
    }

    public function rolesGet(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        $roles = PrivRol::getRows(['@orderBy' => 'nombre']);
        return Application::getRenderer()->renderJson($roles);
    }

    public function usuariosGet(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        $usuarios = Usuario::getRows(['has_permisos' => true, 'nest_permisos' => true, 'link_perfil' => true]);
        $usuariosFound = null;
        $queryParams = $request->getQueryParams();
        if (isset($queryParams['usuario'])) {
        }
        return Application::getRenderer()->renderView('/privilegios/usuarios/indexGet', [
            'title' => 'Usuarios',
            'usuario' => $queryParams['usuario'] ?? '',
            'usuariosFound' => $usuariosFound,
            'usuarios' => $usuarios
        ]);
    }

    public function usuariosIdGet(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        $id_usuario = $params['id'];
        $usuario = [];
        $permisosUsuario = PrivPermiso::getRows(['id_usuario' => $id_usuario]);
        $permisosPerfil = PrivPermiso::getRows(['id_perfil' => $usuario]);
        return Application::getRenderer()->renderView('/privilegios/usuarios/idGet', [
            'title' => "Usuario: <code>{$usuario}</code>",
            'usuario' => $usuario,
            'permisosUsuario' => $permisosUsuario,
            'permisosPerfil' => $permisosPerfil
        ]);
    }

    public function usuariosIdPermisosGet(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        $id_usuario = $params['id'];
        $usuario = [];
        $permisos = PrivPermiso::getRows();
        $permisosUsuario = PrivPermiso::getRows(['id_usuario' => $id_usuario]);
        return Application::getRenderer()->renderView('/privilegios/usuarios/idPermisosGet', [
            'title' => "Permisos para usuario: <code>{$usuario}</code>",
            'usuario' => $usuario,
            'permisos' => $permisos,
            'permisosUsuario' => $permisosUsuario
        ]);
    }

    public function usuariosIdPermisosPost(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        $id_usuario = $params['id'];
        $post = $request->getParsedBody();
        $permisos = $post['permisos'] ?? [];
        PrivUsuarioPermiso::setPermisos($id_usuario, $permisos);
        return Application::getRenderer()->renderRedirect(siteUrl("/privilegios/usuarios/{$id_usuario}"));
    }
}
