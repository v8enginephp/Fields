<?php

namespace Module\Fields;

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/functions.php";

/**
 * Class Fields
 * @package Module\Fields
 */
class Fields
{
    /**
     * Run on Every Time App Run
     */
    public function __construct()
    {
    }

    /**
     * Run on First Time or When Main Table not Exists (Debug Mode)
     */
    public static function onActivate()
    {
        // migrate("fields",dirname(__FILE__));
    }

    public static function onUpdate()
    {
        // migrate("fields",dirname(__FILE__));
    }
}