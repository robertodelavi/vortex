<?php 
    class MySQLDB {
        private $host;
        private $user;
        private $password;
        private $database;
        private $connection;

        public function __construct($host, $user, $password, $database) {
            $this->host = $host;
            $this->user = $user;
            $this->password = $password;
            $this->database = $database;
        }

        public function connect() {
            $dsn = "mysql:host={$this->host};dbname={$this->database}";
            $this->connection = new PDO($dsn, $this->user, $this->password);
            return $this->connection;
        }

        public function disconnect() {
            $this->connection = null;
        }

        public function query($query) {
            return $this->connection->query($query);
        }
    }
?>