
<?php
class Database {
    private $connection;

    public function __construct() {
        $this->connection = new mysqli('localhost', 'root', '', 'scandiweb2');
    }

    public function getConnection() {
        return $this->connection;
    }
}
