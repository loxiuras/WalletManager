<?php

class RedirectService
{

    /**
     * @return void
     */
    public function validateBrowserRedirects(): void
    {
        global $Globals;

        if ( $Globals->getForceWww() && !strstr($_SERVER["HTTP_HOST"], "www.") ) {
            header ("HTTP/1.1 301 Moved Permanently");
            header ("Location: {$Globals->getPrefix()}www.{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}");
            die;
        }
    }
}