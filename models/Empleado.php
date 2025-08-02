<?php
class Empleado {
    private $conn;
    private $table = "empleados";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerTodos(){
        $sql = "SELECT e.id, e.nombre, e.email, e.sexo, e.boletin, a.nombre AS area
                FROM empleados e
                JOIN areas a ON e.area_id = a.id
                ORDER BY e.id DESC";
        
        $query = $this->conn->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC); 
    }

 
    public function crear($data, $roles) {
        $sql = "INSERT INTO empleados (nombre, email, sexo, area_id, boletin, descripcion)
                VALUES (:nombre, :email, :sexo, :area_id, :boletin, :descripcion)";
        $query = $this->conn->prepare($sql);
        $query->execute($data);
        $empleado_id = $this->conn->lastInsertId();

        foreach ($roles as $rol_id) {
            $queryRol = $this->conn->prepare("INSERT INTO empleado_rol (empleado_id, rol_id) VALUES (?, ?)");
            $queryRol->execute([$empleado_id, $rol_id]);
        }
    }
    public function obtenerPorId($id){
        $sql = "SELECT * FROM empleados WHERE id = :id";
        $query = $this->conn->prepare($sql);
        $query->execute([':id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerRolesPorEmpleado($id){
        $sql = "SELECT rol_id FROM empleado_rol WHERE empleado_id = :id";
        $query = $this->conn->prepare($sql);
        $query->execute([':id' => $id]);
        return $query->fetchAll(PDO::FETCH_COLUMN);
    }

    public function actualizar($data, $roles){
        $sql = "UPDATE empleados SET nombre = :nombre, email = :email, sexo = :sexo, area_id = :area_id, boletin = :boletin, descripcion = :descripcion WHERE id = :id";
        $query = $this->conn->prepare($sql);
        $query->execute($data);

        // Actualizar roles
        $this->conn->prepare("DELETE FROM empleado_rol WHERE empleado_id = :id")->execute([':id' => $data[':id']]);
        foreach ($roles as $rol_id) {
            $this->conn->prepare("INSERT INTO empleado_rol (empleado_id, rol_id) VALUES (:empleado_id, :rol_id)")
                ->execute([':empleado_id' => $data[':id'], ':rol_id' => $rol_id]);
        }
    }

    public function eliminar($id){
        $this->conn->prepare("DELETE FROM empleado_rol WHERE empleado_id = :id")->execute([':id' => $id]);
        $this->conn->prepare("DELETE FROM empleados WHERE id = :id")->execute([':id' => $id]);
    }

}