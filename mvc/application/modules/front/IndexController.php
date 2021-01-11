<?php

/**
 * Class IndexController
 */
class IndexController
{

    /** @var string[] */
    private static $applicationDirectories = ['system', 'module'];

    /** @var string */
    private $directory = '';

    /** @var string */
    private $controller = '';

    /**
     * @return string[]
     */
    public static function getApplicationDirectories(): array
    {
        return self::$applicationDirectories;
    }

    /**
     * @return string
     */
    public function getDirectory(): string
    {
        return $this->directory;
    }

    /**
     * @param string $directory
     */
    public function setDirectory(string $directory): void
    {
        $this->directory = $directory;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @param string $controller
     */
    public function setController(string $controller): void
    {
        $this->controller = $controller;
    }

    public function __construct()
    {
        $this->validateDirectoryAndController();
    }

    /**
     * @return array
     */
    private function getUrlKeys(): array
    {
        return $urlKeys = explode( '/', $_SERVER['REQUEST_URI'] );
    }

    /**
     * @return void
     */
    private function validateDirectoryAndController(): void
    {
        $urlKeys = $this->getUrlKeys();

        $urlDirectory  = !empty($urlKeys[1]) ? (string)$urlKeys[1] : null;
        $urlController = !empty($urlKeys[2]) ? (string)$urlKeys[2] : null;

        if ( !empty($urlDirectory) && $this->isDirectoryValid( $urlDirectory ) ) $this->setDirectory( $urlDirectory );
        if ( !empty($urlController) && $this->isControllerValid( $urlController ) ) $this->setController( $urlController );

        if ( empty( $this->getDirectory() ) || empty( $this->getController() ) ) {
            global $Globals;

            header('HTTP/1.1 500 Internal Server Error');
            header('Location: '. $Globals->getPrefix() . $_SERVER['HTTP_HOST'] ."/system/404");
            exit;
        }
    }

    /**
     * @param string $directory
     * @return bool
     */
    private function isDirectoryValid( string $directory ): bool
    {
        return (bool)( !empty($directory) && in_array( $directory, $this::getApplicationDirectories() ) );
    }

    /**
     * @param string $controller
     * @return bool
     */
    private function isControllerValid( string $controller ): bool
    {
        $ModelSystemModules = new ModelSystemModules();

        $fields  = ["moduleId", "controller"];
        $where   = [];
        $where[] = "directory = '{$this->getDirectory()}'";
        $where[] = "controller = '{$controller}'";
        $where[] = "active = 1";
        $orderBy = ["moduleId"];
        $controllerData = $ModelSystemModules->getRecord( $fields, $where, $orderBy );

        return !empty( $controllerData ) && !empty( $controllerData->moduleId );
    }

    /**
     * @return void
     */
    public function dispatch(): void
    {

    }

}