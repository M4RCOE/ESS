<?php

namespace App;

use App\Models\Usuario;
use Francerz\WebappCommons\AbstractSession;

final class Session extends AbstractSession
{
    /** @var Usuario */
    private static $usuario;
    public static function setUser(Usuario $value)
    {
        static::set('usuario', $value);
        static::$usuario = $value;
    }
    public static function getUser(): ?Usuario
    {
        if (!isset(static::$usuario)) {
            static::$usuario = static::get('usuario');
        }
        return static::$usuario;
    }
    public static function unsetUser()
    {
        return static::unset('usuario');
    }
}
