<?php
/**
 * Substance Information Tool
 * MySQL Database Driver Class
 *
 * @author Harry Staszewski
 */

require_once("interface.dbdriver.php");
require_once("class.appsettings.php");

class MySQLDriver implements DBDriver 
{
    private static $driver_instance;
    private $pdo;
    
    private function __construct() {
        $this->connect();
    }
    
    public function connect() {
        $appsettings = AppSettings::getInstance();
        
        try {
            $this->pdo = new PDO("mysql:host=" . $appsettings->getDBHost() . ";dbname=" . $appsettings->getDBName(), $appsettings->getDBUser(), $appsettings->getDBPassword());
        }
        catch (PDOException $e)
        {
            echo "Failed to connect to database, the error message was : " . $e->getMessage();
            exit();
        }
    }
    
    public function execute($statement, $params = "") {
        $stmt = $this->pdo->prepare($statement);
        $stmt->execute($params);
        if (!($stmt->errorCode==0))
        {
            echo "PDOStatement::errorInfo():\n";
            print_r($stmt->errorInfo());
            exit();
        }
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
    
    public static function getInstance() {
        if (!self::$driver_instance)
        {
            self::$driver_instance = new self();
        }
        
        return self::$driver_instance;
    }
    
    public function lastInsertId() {
        return $this->pdo->lastInsertID();
    }
    
    public function close() {
        if ($this->pdo)
        {
            $this->pdo = NULL;
        }
    }
    
    public function __destruct() {
        $this->close();
    }
}
?>
