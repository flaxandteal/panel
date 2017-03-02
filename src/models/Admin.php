<?php
namespace Serverfireteam\Panel;

use App\Models\Users\User;

class Admin extends User {

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new AdminScope);
    }
}
