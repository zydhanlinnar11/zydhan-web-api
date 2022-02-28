<?php

namespace Modules\Auth\Facade;

use Illuminate\Support\Facades\Facade;


/**
 * @method static \Modules\Auth\Domain\Models\Entity\User user(\Illuminate\Http\Request $request)
 */
class Auth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'auth_module';
    }
}