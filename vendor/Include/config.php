<?php

class Config_db{

    public $connec;
    private $server = "localhost";
    private $dbname = "pharmacy";
    private $username = "root";
    private $password = "";

    public function connect()
    {
        
        try {
            $dsn = "mysql:host=".$this->server.";dbname=".$this->dbname.";";
            $this->connec = new PDO($dsn, $this->username, $this->password);
            $this->connec->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $err) {
            
            echo "Connection Failed:". $err->getMessage();
        }

        return $this->connec;
    }
}
?>