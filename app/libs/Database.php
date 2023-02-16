<?php
/* 
    Database class is responsible for DB access, writing 
*/

/**
 * Provides functionality for database accessing
 */
class Database
{

    private $dbh;
    private $stmt;

    /**
     * Init new PDO and DSN connection
     */
    public function __construct()
    {
        $host = 'localhost';
        $user = 'nurkharl';
        $pass = 'webove aplikace';
        $dbname = 'nurkharl';

        $params = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        // Create a new PDO instance
        try {
            $this->dbh = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $pass, $params);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    /**
     * Prepare a SQL statement for execution
     * @param $sql
     * @return void
     */
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }


    /**
     * Binds a value to a corresponding named or question mark placeholder in the SQL statement.
     * @param $param
     * @param $value
     * @param $type
     * @return void
     */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {

                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * Execute the prepared statement
     * @return mixed
     */
    public function execute()
    {
        return $this->stmt->execute();
    }

    /**
     * Get result set as array of objects
     * @return mixed
     */
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }


    /**
     * Get single record as object
     * @return mixed
     */
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     *  Get SQL statement row output count
     * @return mixed
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}
