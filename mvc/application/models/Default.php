<?php

/**
 * Class ModelDefault
 */
class ModelDefault
{

    /** @var string */
    private $name = '';

    /** @var string */
    private $primaryKey = '';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    /**
     * @param string $primaryKey
     */
    public function setPrimaryKey(string $primaryKey): void
    {
        $this->primaryKey = $primaryKey;
    }

    /**
     * ModelDefault constructor.
     */
    public function __construct() {}

    /**
     * @param array $fields
     * @param array $where
     * @param null $orderBy
     * @return null
     */
    public function getRecord( array $fields = [], array $where = [], $orderBy = null )
    {
        return $this->getRecords( $fields, $where, $orderBy, 1 );
    }

    /**
     * @param array $fields
     * @param array $where
     * @param null $orderBy
     * @param int $limit
     * @return mixed
     */
    public function getRecords( array $fields = [], array $where = [], $orderBy = null, int $limit = 99999 )
    {
        $query = (new ConfigDatabaseQuery( $this->getName() ));

        if ( empty( $fields ) ) $fields = ["{$this->getPrimaryKey()}"];
        $query->addField( $fields );

        if ( !empty( $where ) && count( $where ) > 0 ) {
            foreach ( $where as $item ) {
                $query->addWhere( $item );
            }
        }

        if ( !empty( $orderBy ) ) $query->addOrderBy( $orderBy );

        if ( $limit === 1 ) return $query->fetchRow();

        return $query->fetchAll();
    }

}