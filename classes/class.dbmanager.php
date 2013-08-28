<?php
/**
 * Substance Information Tool
 * Database Manager Class
 *
 * @author Harry Staszewski
 */

require_once("class.mysqldriver.php");

class DBManager 
{
    public static function getDBDriver($driver) {
        switch ($driver) {
            case "MySQL":
                return self::getMySQLDriver();
                break;

            default:
                echo ("Invalid Database Driver Specified.
                    \nPlease ensure a supported database driver is specified
                    in application settings.");
                exit();
        }
    }
    
    public static function getMySQLDriver() {
        return MySQLDriver::getInstance();
    }
    
}
?>
