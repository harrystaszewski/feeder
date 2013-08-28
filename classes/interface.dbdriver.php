<?php
/**
 * Substance Information Tool
 * Database Driver Interface
 * 
 * @author Harry Staszewski
 */

interface DBDriver {
    public function connect();
    public function execute($statement, $params = "");
    public static function getInstance();
    public function lastInsertId();
    public function close();
}
?>
