<?php

namespace Folospace\ChineseHoliday\Facades;

use Illuminate\Support\Facades\Facade;

class ChineseHoliday extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'chineseholiday';
    }
}
