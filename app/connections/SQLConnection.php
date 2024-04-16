<?php

namespace App\Connections;

/**
 * SQL connnection
 */
class SQLConnection {
    /**
     * PDO instance
     * 
     */
    private $pdo;

    /**
     * return in instance of the PDO object that connects to the SQLite database
     * @return \PDO
     */
    public function connect() {

        if ($this->pdo == null) { // check if the database is not already connected

            //$this->pdo = new \PDO("sqlite:" . Config::PATH_TO_SQLITE_FILE);
            try {

                $options = [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION];
            
                $this->pdo = new \PDO("sqlite:" .Config::PATH_TO_SQLITE_FILE);
            
               

            } 
            catch (\PDOException $e) {
                echo $e->getMessage();
            }




        }
        return $this->pdo;
        
    }
   
   
}
?>