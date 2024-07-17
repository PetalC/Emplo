<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class EmailTemplateFacade extends Facade {
    protected static function getFacadeAccessor() {
        return 'email_template';
    }

}
