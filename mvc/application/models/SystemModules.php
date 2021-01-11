<?php

/**
 * Class ModelSystemModules
 */
class ModelSystemModules extends ModelDefault
{

    /** @var string */
    private static $modelName = 'module';

    /** @var string */
    private static $modelPrimaryKey = 'moduleId';

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