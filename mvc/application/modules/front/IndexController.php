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
     * @return void
     */
    private function validateDirectoryAndController(): void
    {
        $urlKeys = explode( '/', $_SERVER['REQUEST_URI'] );

        $urlDirectory  = !empty($urlKeys[1]) ? (string)$urlKeys[1] : null;
        $urlController = !empty($urlKeys[2]) ? (string)$urlKeys[2] : null;

        if ( !empty($urlDirectory) && $this->isDirectoryValid( $urlDirectory ) ) $this->setDirectory( $urlDirectory );
        if ( !empty($urlController) && $this->isControllerValid( $urlController ) ) $this->setController( $urlController );
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


        return true;
    }

    /**
     * @return void
     */
    public function dispatch(): void
    {

    }

}