<?php
 /*
  * PDO Database Class
  * Connect to database
  * Create prepared statements
  * Bind values
  * Return rows and results
  */
    class Database
    {
        //Variabls  DB
        private $host = DB_HOST;
        private $usr = DB_USER;
        private $pass = DB_PASS;
        private $dbname = DB_NAME;
        /* database_handler*/
        private $cn;
        private $req;
        private $error;

        public function __construct()
        {
            // Set DSN (database source name)
            $chaine = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            try{
                $this->cn = new PDO($chaine, $this->usr, $this->pass);
            }catch (PDOException $e){
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }
        // Query Method
        public function query($sql)
        {
            $this->req = $this->cn->prepare($sql);
        }
        // Bind Method
        public function bind($param, $value, $type = null)
        {
            if(is_null($type)){
                switch (true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                        case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                        case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                       
                    default:
                    $type = PDO::PARAM_STR;
                        break;
                }

            }
            $this->req->bindvalue($param, $value, $type);
        }
        //Execute Method
        public function execute()
        {
            return $this->req->execute();
        }
        //Set Result Method
        public function resultSet()
        {
            $this->execute();
            return $this->req->fetchAll(PDO::FETCH_OBJ);
        }
        //Single Method
        public function single()
        {
            $this->execute();
            return $this->req->fetch(PDO::FETCH_OBJ);
        }
        //Count Rowes
        public function rowCount()
        {
            return $this->req->rowCount();
        }
        //Fetch Columns
        public function fetchColumn()
        {
            $this->execute();
            return $this->req->fetchColumn();
        }
    }
?>