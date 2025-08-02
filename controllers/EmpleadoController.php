<?php 
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Empleado.php';

$db = new Database();
$conn = $db->conectar();
$empleadoModel = new Empleado($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? 'crear'; 

    $id = $_POST['id'] ?? null;
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $sexo = $_POST['sexo'] ?? '';
    $area_id = $_POST['area_id'] ?? '';
    $boletin = isset($_POST['boletin']) ? 1 : 0;
    $descripcion = trim($_POST['descripcion'] ?? '');
    $roles = $_POST['roles'] ?? [];

    if ($accion !== 'eliminar') {
        $errores = [];

        if ($nombre === '') $errores[] = "El nombre es obligatorio.";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "Correo electrónico no válido.";
        if (!in_array($sexo, ['M', 'F'])) $errores[] = "Debes seleccionar un sexo.";
        if (!is_numeric($area_id)) $errores[] = "Área inválida.";
        if ($descripcion === '') $errores[] = "La descripción es obligatoria.";
        if (empty($roles)) $errores[] = "Debes seleccionar al menos un rol.";

        if (!empty($errores)) {
            $_SESSION['errores'] = $errores;
            $_SESSION['old'] = $_POST;

            if ($accion === 'editar') {
                header("Location: ../views/empleados/editar.php?id=$id");
            } else {
                header("Location: ../views/empleados/crear.php");
            }
            exit();
        }
    }

    if ($accion === 'crear') {
        $data = [
            ':nombre' => $nombre,
            ':email' => $email,
            ':sexo' => $sexo,
            ':area_id' => $area_id,
            ':boletin' => $boletin,
            ':descripcion' => $descripcion,
        ];

        $empleadoModel->crear($data, $roles);
        $_SESSION['success'] = "Empleado creado exitosamente.";
        header("Location: ../views/empleados/listar.php");
        exit();
    }

    if ($accion === 'editar') {
        $data = [
            ':id' => $id,
            ':nombre' => $nombre,
            ':email' => $email,
            ':sexo' => $sexo,
            ':area_id' => $area_id,
            ':boletin' => $boletin,
            ':descripcion' => $descripcion,
        ];

        $empleadoModel->actualizar($data, $roles);
        $_SESSION['success'] = "Empleado actualizado correctamente.";
        header("Location: ../views/empleados/listar.php");
        exit();
    }

    if ($accion === 'eliminar') {
        $id = $_POST['id'];
        $empleadoModel->eliminar($id);
        $_SESSION['success'] = "Empleado eliminado correctamente.";
        header("Location: ../views/empleados/listar.php");
        exit();
    }
}
