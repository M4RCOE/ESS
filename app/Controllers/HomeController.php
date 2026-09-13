<?php

namespace App\Controllers;

use App\Application;
use App\Exceptions\AppFlowException;
use App\Models\Usuario;
use App\Session;
use Psr\Http\Message\ResponseInterface as IResponse;
use Psr\Http\Message\ServerRequestInterface as IServerRequest;

use function Francerz\Http\Utils\siteUrl;

class HomeController extends AbstractController
{
    public function indexGet(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        return Application::getRenderer()->renderView('/home/indexGet');
    }

    public function loginGet(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        if (!is_null(Session::getUser())) {
            return Application::getRenderer()->renderRedirect(siteUrl());
        }
        $get = $request->getQueryParams();
        $e = $get['e'] ?? '';
        $error = '';
        $id_usuario = '';

        if ($e !== '') {
            $datos = explode('-', $e);
            $indiceError = $datos[0] ?? null;
            $id_usuario = $datos[1] ?? '';

            $errors = [
                'Credenciales incorrectas', // Índice 0
                'El usuario no esta activo verifique con el administrador del sistema.', // Índice 1
            ];
            if (isset($errors[$indiceError])) {
                $error = $errors[$indiceError];
            } else {
                $error = 'Error desconocido';
            }
        }

        if (!is_null($error)) {
            if (!empty($id_usuario)) {
                $usuario = Usuario::getFirst(['id_usuario' => $id_usuario]);
            }
            $data = [
                'usuario' => $usuario->usuario ?? '',
                'error' => $error
            ];
        }
        return Application::getRenderer()->renderView('/home/loginGet', $data);
    }

    public function loginPost(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        if (!is_null(Session::getUser())) {
            return Application::getRenderer()->renderRedirect(siteUrl());
        }
        $post = $request->getParsedBody();
        $usuario = $post['usuario'];
        $contrasena = $post['contrasena'];
        $usuarioDB = Usuario::getFirst(['usuario' => $usuario, 'link_perfil' => true]);
        if (!$usuarioDB || !password_verify($contrasena, $usuarioDB->contrasena)) {
            return Application::getRenderer()->renderRedirect(siteUrl("/login?e=0"));
        }
        if ($usuarioDB->estatus == 0) {
            return Application::getRenderer()->renderRedirect(siteUrl("/login?e=1"));
        }
        Session::setUser($usuarioDB);
        return Application::getRenderer()->renderRedirect(siteUrl());
    }
    public function logOutGet(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        Session::unsetUser();
        Session::destroy();
        return Application::getRenderer()->renderRedirect(siteUrl("/login"));
    }
}
