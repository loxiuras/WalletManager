<?php

/**
 * Class ConfigDatabase
 */
class ConfigDatabaseQuery
{

    /** @var string */
    private $name = "";

    /** @var array */
    private $fields = [];

    /** @var array */
    private $where = [];

    /** @var array */
    private $orderBy = [];

    /** @var array */
    private $executes = [];

    /** @var int|null */
    private $limit = null;

    /** @var array */
    private static $selectParams = [">", ">=", "<", "<=", "=", "!="];

    /** @var string */
    private static $defaultOrderBy = "ASC";

    /**
     * @return string
     */
    private function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    private function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    private function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     */
    private function setFields(array $fields): void
    {
        $this->fields = $fields;
    }

    /**
     * @return bool
     */
    private function hasFields(): bool
    {
        $fields = $this->getFields();
        return !empty( $fields ) && count( $fields ) > 0;
    }

    /**
     * @return array
     */
    private function getWhere(): array
    {
        return $this->where;
    }

    /**
     * @param array $where
     */
    private function setWhere(array $where): void
    {
        $this->where = $where;
    }

    /**
     * @return bool
     */
    private function hasWhere(): bool
    {
        $where = $this->getWhere();
        return !empty( $where ) && count( $where ) > 0;
    }

    /**
     * @return array
     */
    private function getOrderBy(): array
    {
        return $this->orderBy;
    }

    /**
     * @param array $orderBy
     */
    private function setOrderBy(array $orderBy): void
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @return bool
     */
    private function hasOrderBy(): bool
    {
        $orderBy = $this->getOrderBy();
        return !empty( $orderBy ) && count( $orderBy ) > 0;
    }

    /**
     * @return array
     */
    private function getExecutes(): array
    {
        return $this->executes;
    }

    /**
     * @param array $executes
     */
    private function setExecutes(array $executes): void
    {
        $this->executes = $executes;
    }

    /**
     * @return bool
     */
    private function hasExecutes(): bool
    {
        $executes = $this->getExecutes();
        return !empty( $executes ) && count( $executes ) > 0;
    }

    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return array
     */
    private static function getSelectParams(): array
    {
        return self::$selectParams;
    }

    /**
     * @return string
     */
    public static function getDefaultOrderBy(): string
    {
        return self::$defaultOrderBy;
    }

    /**
     * ConfigDatabaseQuery constructor.
     * @param string $name
     */
    public function __construct( string $name )
    {
        $this->setName( $name );
    }

    /**
     * @param $field
     * @return void
     */
    public function addField( $field ): void
    {
        if ( !empty( $field ) ) {
            $fields = $this->getFields();

            if ( is_array( $field ) ) {

                foreach ( $field as $item ) {
                    $fields[] = $item;
                }
            }
            else {
                $fields[] = $field;
            }

            $this->setFields( $fields );
        }
    }

    /**
     * @param $where
     * @return void
     */
    public function addWhere( $where ): void
    {
        if ( !empty( $where ) ) {
            $wheres = $this->getWhere();

            if ( is_array( $where ) ) {

                foreach ( $where as $item ) {
                    $wheres[] = $item;
                }
            }
            else {
                $wheres[] = $where;
            }

            $this->setWhere( $wheres );
        }
    }

    /**
     * @param $orderBy
     * @return void
     */
    public function addOrderBy( $orderBy ): void
    {
        if ( !empty( $orderBy ) ) {
            $orderBys = $this->getOrderBy();

            if ( is_array( $orderBy ) ) {

                foreach ( $orderBy as $item ) {
                    $orderBys[] = $item;
                }
            }
            else {
                $orderBys[] = $orderBy;
            }

            $this->setOrderBy( $orderBys );
        }
    }

    /**
     * @param $execute
     * @return void
     */
    private function addExecutes( $execute ): void
    {
        if ( !empty( $execute ) ) {
            $executes = $this->getExecutes();

            if ( is_array( $execute ) ) {

                foreach ( $execute as $item ) {
                    $executes[] = $item;
                }
            }
            else {
                $executes[] = $execute;
            }

            $this->setExecutes( $executes );
        }
    }

    /**
     * @return mixed
     */
    public function fetchRow()
    {
        return $this->fetch( true );
    }

    /**
     * @return mixed
     */
    public function fetchAll()
    {
        return $this->fetch();
    }

    /**
     * @param bool $single
     * @return mixed
     */
    private function fetch( bool $single = false )
    {
        global $connection;

        $sql = "SELECT ";

        if ( $this->hasFields() ) {

            $fieldLength = count( $this->getFields() );
            foreach ( $this->getFields() as $fieldCount => $field ) {
                $sql .= (string)$field;
                if ( $fieldLength - 1 !== $fieldCount ) $sql .= ", ";
            }
        }

        $sql .= " FROM {$this->getName()}";
        
        if ( $this->hasWhere() ) {
            $sql .= " WHERE ";

            $whereLength   = count( $this->getWhere() );
            $execute = [];
            foreach ( $this->getWhere() as $whereCount => $where ) {

                if ( strstr( strtoupper($where), "IS NOT" ) ) {
                    $sql .= (string)$where;
                }
                else {
                    $keys     = explode("-", str_replace( $this::getSelectParams() , "-", $where));
                    $keyParam = array_pop( $keys );

                    $where = str_replace( $keyParam, '?', $where );

                    $sql .= str_replace( ' ', '', trim( $where ) );

                    $execute[] = $keyParam;
                }

                if ( $whereLength - 1 !== $whereCount ) $sql .= " AND ";
            }

            $this->addExecutes( $execute );
        }

        if ( $this->hasOrderBy() ) {
            $sql .= " ORDER BY ";

            $orderLength = count( $this->getOrderBy() );
            foreach ( $this->getOrderBy() as $orderCount => $order ) {
                $orderKeys = explode( " ", $order );
                $orderParam = array_shift( $orderKeys );
                $orderType = array_pop( $orderKeys );

                if ( empty( $orderType ) ) $orderType = $this::getDefaultOrderBy();

                $sql .= "? {$orderType}";

                if ( $orderLength - 1 !== $orderCount ) $sql .= ", ";

                $this->addExecutes( $orderParam );
            }
        }

        if ( null !== $this->getLimit() || $single ) {
            $limit = $single ? 1 : $this->getLimit();

            $sql .= " LIMIT ?";

            $this->addExecutes( $limit );
        }
        
        $query = $connection->getPDO()->prepare( $sql );

        if ( $this->hasExecutes() ) {

            $executes = [];
            foreach ( $this->getExecutes() as $execute ) {
                $executes[] = trim( str_replace("'", "", (string)$execute) );
            }

            $query->execute($executes);
        }

        if ( $single ) {
            return $query->fetch(PDO::FETCH_OBJ);
        } else {
            return $query->fetchAll(PDO::FETCH_OBJ);
        }
    }
}