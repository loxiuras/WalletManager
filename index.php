<?php

require_once "autoload.php";
require_once "mvc/application/configs/Globals.php";

$Globals = new Globals();

if ( $Globals->getActiveEnvironment() !== $Globals::getEnvironmentProduction() ) {
    (new RedirectService())->validateBrowserRedirects();
}

try {

    (new IndexController())->dispatch();

}
catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
