<?php

require_once "autoload.php";

$Globals = new ConfigGlobals();

if ( $Globals->getActiveEnvironment() !== $Globals::getEnvironmentProduction() ) {
    (new RedirectService())->validateBrowserRedirects();
}

try {

    (new IndexController())->dispatch();

}
catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
