<?php
namespace Serverfireteam\Panel;

use App\User;

class Admin extends User
{
    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new AdminScope);
    }
}
