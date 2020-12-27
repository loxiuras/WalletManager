<?php

/**
 * Class ConfigDatabase
 */
class ConfigDatabaseConnection
{
    /** @var mixed */
    protected $PDO;

    /**
     * @return mixed
     */
    public function getPDO()
    {
        return $this->PDO;
    }

    /**
     * @param mixed $PDO
     */
    public function setPDO($PDO): void
    {
        $this->PDO = $PDO;
    }

    /**
     * ConfigDatabase constructor.
     */
    public function __construct()
    {
        global $Globals;

        $host    = $Globals->getDatabaseSetting('host');
        $db      = $Globals->getDatabaseSetting('name');
        $user    = $Globals->getDatabaseSetting('username');
        $pass    = $Globals->getDatabaseSetting('password');
        $port    = $Globals->getDatabaseSetting('post');
        $charset = $Globals->getDatabaseSetting('charset');
        $dsn     = "mysql:host=$host;dbname=$db;port=$port;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $this->setPDO( new PDO($dsn, $user, $pass, $options) );
    }

}