<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Area.php';
require_once __DIR__ . '/../../models/Rol.php';

$db = new Database();
$conn = $db->conectar();

$areaModel = new Area($conn);
$rolModel = new Rol($conn);

$areas = $areaModel->obtenerTodas();
$roles = $rolModel->obtenerTodos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Crear nuevo empleado</h2>

        <?php if (isset($_SESSION['errores'])): ?>
            <div class="alert alert-danger">
                <h5>Corrige los siguientes errores:</h5>
                <ul class="mb-0">
                    <?php foreach ($_SESSION['errores'] as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="../../controllers/EmpleadoController.php" method="POST" class="bg-white p-4 shadow rounded needs-validation" novalidate>
            <div class="mb-3">
                <label class="form-label">Nombre completo:</label>
                <input type="text" name="nombre" class="form-control" required
                       value="<?= $_SESSION['old']['nombre'] ?? '' ?>">
                <div class="invalid-feedback">
                    Por favor ingresa el nombre del empleado.
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Correo electrónico:</label>
                <input type="email" name="email" class="form-control" required
                       value="<?= $_SESSION['old']['email'] ?? '' ?>">
                <div class="invalid-feedback">
                    Ingresa un correo electrónico válido.
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Sexo:</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="sexo" value="M" required

                        <?= (isset($_SESSION['old']['sexo']) && $_SESSION['old']['sexo'] === 'M') ? 'checked' : '' ?>>

                    <label class="form-check-label">Masculino</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="sexo" value="F" required

                        <?= (isset($_SESSION['old']['sexo']) && $_SESSION['old']['sexo'] === 'F') ? 'checked' : '' ?>>

                    <label class="form-check-label">Femenino</label>
                </div>
                <div class="invalid-feedback d-block">
                    Debes seleccionar un sexo.
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Área:</label>
                <select name="area_id" class="form-select" required>
                    <option value="">Seleccione...</option>
                    <?php while ($area = $areas->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= $area['id'] ?>"
                            <?= (isset($_SESSION['old']['area_id']) && $_SESSION['old']['area_id'] == $area['id']) ? 'selected' : '' ?>>
                            <?= $area['nombre'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <div class="invalid-feedback">
                    Selecciona un área válida.
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción:</label>
                <textarea name="descripcion" class="form-control" rows="4" required><?= $_SESSION['old']['descripcion'] ?? '' ?></textarea>
                <div class="invalid-feedback">
                    Describe brevemente al empleado.
                </div>
            </div>
            <div class="mb-3 form-check">
                <input class="form-check-input" type="checkbox" name="boletin" value="1"
                       <?= isset($_SESSION['old']['boletin']) ? 'checked' : '' ?>>
                <label class="form-check-label">Deseo recibir boletín informativo</label>
            </div>
            <div class="mb-3">
                <label class="form-label">Roles:</label>
                <?php while ($rol = $roles->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="<?= $rol['id'] ?>"
                            <?= (isset($_SESSION['old']['roles']) && in_array($rol['id'], $_SESSION['old']['roles'])) ? 'checked' : '' ?>>
                        <label class="form-check-label"><?= $rol['nombre'] ?></label>
                    </div>
                <?php endwhile; ?>
                <div class="invalid-feedback d-block">
                    Debes seleccionar al menos un rol.
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="listar.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })();
    </script>
</body>
</html>

<?php
unset($_SESSION['errores']);
unset($_SESSION['old']); 
?>
