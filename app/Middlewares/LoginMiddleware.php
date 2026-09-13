<?php

namespace App\Middlewares;

use App\Application;
use App\Session;
use Psr\Http\Message\ResponseInterface as IResponse;
use Psr\Http\Message\ServerRequestInterface as IServerRequest;
use Psr\Http\Server\RequestHandlerInterface as IRequestHandler;

use function Francerz\Http\Utils\siteUrl;

class LoginMiddleware extends AbstractMiddleware
{
    public function process(IServerRequest $request, IRequestHandler $handler): IResponse
    {

        if (is_null(Session::getUser())) {
            return Application::getRenderer()->renderRedirect(siteUrl("/login"));
        }
        return $handler->handle($request);
    }
}
