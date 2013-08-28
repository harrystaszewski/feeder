<?php
/**
 * Substance Information Tool
 * Application Settings Class
 *
 * @author Harry Staszewski
 */
final class AppSettings {
    const SETTINGS_FILENAME = "settings.ini";
    
    private static $settings_instance;
    
    private $db_driver;
    private $db_host;
    private $db_name;
    private $db_user;
    private $db_password;
    
    private function __construct() 
    {
        $this->loadSettings();
    }
    
    private function loadSettings()
    {
        if (file_exists(self::SETTINGS_FILENAME))
        {
            $settings = parse_ini_file(self::SETTINGS_FILENAME, TRUE);
            if ($settings)
            {
                $this->db_driver = $settings['database']['db_driver'];
                $this->db_host = $settings['database']['db_host'];
                $this->db_name = $settings['database']['db_name'];
                $this->db_user = $settings['database']['db_user'];
                $this->db_password = $settings['database']['db_password'];
            }
            else
            {
                $this->setDefaults();
            }
        }
        else
        {
            $this->setDefaults();
        }
    }
    
    public function saveSettings()
    {
        $settings = "[database]\n";
        $settings .= "db_driver = " . $this->db_driver . "\n";
        $settings .= "db_host = " . $this->db_host . "\n";
        $settings .= "db_name = " . $this->db_name . "\n";
        $settings .= "db_user = " . $this->db_user . "\n";
        $settings .= "db_password = " . $this->db_password . "\n";
        
        file_put_contents(self::SETTINGS_FILENAME, $settings);
    }

    public static function getInstance()
    {
        if (!self::$settings_instance)
        {
            self::$settings_instance = new self();
        }
        
        return self::$settings_instance;
    }
    
    private function setDefaults()
    {
        $this->db_driver = "MySQL";
        $this->db_host = "localhost";
        $this->db_name = "feeder";
        $this->db_user = "root";
        $this->db_password = "";
        
        $this->saveSettings();
    }
    
    public function getDBDriver()
    {
        return $this->db_driver;
    }
    
    public function getDBHost()
    {
        return $this->db_host;
    }
    
    public function getDBName()
    {
        return $this->db_name;
    }
    
    public function getDBUser()
    {
        return $this->db_user;
    }
    
    public function getDBPassword()
    {
        return $this->db_password;
    }
}
?>
