<?php
class Rol {
    private $conn;
    private $table = "roles";

    public function __construct($db) {
        $this->conn = $db;
    }
 
    public function obtenerTodos() {
        $query = $this->conn->prepare("SELECT * FROM roles");
        $query->execute();
        return $query;
    }
}