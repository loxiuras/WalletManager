<?php

require_once "autoload.php";
require_once "mvc/application/configs/Globals.php";

$Globals = new Globals();

if ( $Globals->getActiveEnvironment() !== $Globals::getEnvironmentProduction() ) {
    (new RedirectService())->validateBrowserRedirects();
}


