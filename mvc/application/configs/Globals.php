<?php

/**
 * Class ConfigGlobals
 */
class ConfigGlobals
{

    /** @var string */
    const configFile = 'config.ini';

    /** @var string */
    const configLocation = "mvc/application/configs/";

    /** @var string */
    private static $environmentProduction = "production";

    /** @var string */
    private static $environmentDevelopment = "development";

    /** @var null|mixed */
    private $ini = null;

    /**
     * @return string
     */
    public static function getEnvironmentProduction()
    {
        return self::$environmentProduction;
    }

    /**
     * @return string
     */
    public static function getEnvironmentDevelopment()
    {
        return self::$environmentDevelopment;
    }

    /**
     * @return mixed|null
     */
    public function getIni()
    {
        return $this->ini;
    }

    /**
     * @param mixed|null $ini
     *
     * @return void
     */
    public function setIni( $ini ): void
    {
        $this->ini = $ini;
    }

    /**
     * @return void
     */
    private function initIni(): void
    {
        if ( file_exists( self::configLocation . self::configFile ) ) {
            $ini = parse_ini_file(self::configFile, true);
            $this->setIni( $ini );
        }
    }

    public function __construct()
    {
        $this->initIni();
    }

    /**
     * @param string $group
     * @return array|null
     */
    private function getIniGroup( string $group ): ?array
    {
        $ini = $this->getIni();
        return !empty( $ini[$group] ) ? $ini[$group] : null;
    }

    /**
     * @param string $group
     * @param string $param
     *
     * @return string|null
     */
    private function getIniContent( string $group, string $param ): ?string
    {
        $iniGroup = $this->getIniGroup( $group );
        return !empty( $iniGroup[$param] ) ? (string)$iniGroup[$param] : null;
    }

    /**
     * @return string
     */
    public function getActiveEnvironment(): string
    {
        return $this->getIniContent( 'environments', 'environment.active' );
    }

    /**
     * @return bool
     */
    public function getForceWww(): bool
    {
        return !empty( $this->getIniContent( $this->getActiveEnvironment(), 'system.forceWww' ) );
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->getIniContent( $this->getActiveEnvironment(), 'system.prefix' );
    }
}