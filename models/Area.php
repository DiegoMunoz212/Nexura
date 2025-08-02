<?php
class Area { 
    private $conn;
    private $table = "areas";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerTodas() {
        $query = $this->conn->prepare("SELECT * FROM areas");
        $query->execute();
        return $query;
    }
}