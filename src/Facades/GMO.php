<?php

namespace DehaSoft\LaravelGmoPayment\Facades;

use Illuminate\Support\Facades\Facade;

class GMO extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'gmo';
    }

}