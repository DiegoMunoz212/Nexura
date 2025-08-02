<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Empleado.php';

$db = new Database();
$conn = $db->conectar();
$empleadoModel = new Empleado($conn);
$empleados = $empleadoModel->obtenerTodos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
 
<div class="container mt-5">
    <h2 class="mb-4">Empleados registrados</h2>
    <!-- MENSAJE DE ÉXITO -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <a href="crear.php" class="btn btn-primary mb-3">Nuevo Empleado</a>
    <div class="table-responsive">
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Sexo</th>
                    <th>Área</th>
                    <th>Boletín</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($empleados) > 0): ?>
                    <?php foreach ($empleados as $emp): ?>
                        <tr>
                            <td><?= $emp['id'] ?></td>
                            <td><?= htmlspecialchars($emp['nombre']) ?></td>
                            <td><?= htmlspecialchars($emp['email']) ?></td>
                            <td><?= $emp['sexo'] == 'M' ? 'Masculino' : 'Femenino' ?></td>
                            <td><?= htmlspecialchars($emp['area']) ?></td>
                            <td><?= $emp['boletin'] ? 'Sí' : 'No' ?></td>
                            <td>
                                <a href="editar.php?id=<?= $emp['id'] ?>" class="btn btn-sm btn-warning">✏️ Editar</a>

                                <form action="../../controllers/EmpleadoController.php" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar este empleado?');">
                                    <input type="hidden" name="accion" value="eliminar">
                                    <input type="hidden" name="id" value="<?= $emp['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">🗑️ Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center">No hay empleados registrados</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
