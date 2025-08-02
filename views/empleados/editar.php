<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Empleado.php';
require_once __DIR__ . '/../../models/Area.php';
require_once __DIR__ . '/../../models/Rol.php';

if (!isset($_GET['id'])) {
    header("Location: listar.php");
    exit();
}

$id = $_GET['id'];
$db = new Database();
$conn = $db->conectar();
$empleadoModel = new Empleado($conn);
$areaModel = new Area($conn);
$rolModel = new Rol($conn);

$empleado = $empleadoModel->obtenerPorId($id);
$areas = $areaModel->obtenerTodas();
$roles = $rolModel->obtenerTodos();
$rolesEmpleado = $empleadoModel->obtenerRolesPorEmpleado($id);
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2>Editar empleado</h2>
        <form action="../../controllers/EmpleadoController.php" method="POST" class="bg-white p-4 shadow rounded">
            <input type="hidden" name="accion" value="editar">
            <input type="hidden" name="id" value="<?= $empleado['id'] ?>">

            <div class="mb-3">
                <label class="form-label">Nombre:</label>
                <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($empleado['nombre']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($empleado['email']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Sexo:</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="sexo" value="M" <?= $empleado['sexo'] == 'M' ? 'checked' : '' ?>>
                    <label class="form-check-label">Masculino</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="sexo" value="F" <?= $empleado['sexo'] == 'F' ? 'checked' : '' ?>>
                    <label class="form-check-label">Femenino</label>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Área:</label>
                <select name="area_id" class="form-select">
                    <?php while ($area = $areas->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= $area['id'] ?>" <?= $empleado['area_id'] == $area['id'] ? 'selected' : '' ?>>
                            <?= $area['nombre'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción:</label>
                <textarea name="descripcion" class="form-control" required><?= htmlspecialchars($empleado['descripcion']) ?></textarea>
            </div>
            <div class="mb-3 form-check">
                <input class="form-check-input" type="checkbox" name="boletin" value="1" <?= $empleado['boletin'] ? 'checked' : '' ?>>
                <label class="form-check-label">Deseo recibir boletín informativo</label>
            </div>
            <div class="mb-3">
                <label class="form-label">Roles:</label>
                <?php while ($rol = $roles->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="<?= $rol['id'] ?>"
                            <?= in_array($rol['id'], $rolesEmpleado) ? 'checked' : '' ?>>
                        <label class="form-check-label"><?= $rol['nombre'] ?></label>
                    </div>
                <?php endwhile; ?>
            </div>
            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="listar.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
