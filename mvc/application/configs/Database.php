<?php

/**
 * Class ConfigDatabase
 */
class ConfigDatabase
{

    /**
     * ConfigDatabase constructor.
     */
    public function __construct()
    {
        global $Globals;


        echo "<pre>";
        var_dump( $Globals );
        echo "</pre>";
        die;
    }

}