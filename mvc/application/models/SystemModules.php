<?php

/**
 * Class ModelSystemModules
 */
class ModelSystemModules extends ModelDefault
{

    /** @var string */
    private static $modelName = '';

    /** @var string */
    private static $modelPrimaryKey = '';

    /**
     * @return string
     */
    public static function getModelName(): string
    {
        return self::$modelName;
    }

    /**
     * @return string
     */
    public static function getModelPrimaryKey(): string
    {
        return self::$modelPrimaryKey;
    }

    /**
     * ModelSystemModules constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setName( $this::getModelName() );
        $this->setPrimaryKey( $this::getModelPrimaryKey() );
    }

}