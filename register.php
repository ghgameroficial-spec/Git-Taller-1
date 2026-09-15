<?php
require_once __DIR__ . '/db.php';

// If user is already logged in, redirect to catalog
if (isset($_SESSION['user_id'])) {
    header('Location: catalog.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $documento = trim($_POST['documento'] ?? '');
    $nombre    = trim($_POST['nombre'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $correo    = trim($_POST['correo'] ?? '');
    $ciudad    = trim($_POST['ciudad'] ?? '');
    $pais      = trim($_POST['pais'] ?? '');
    $password  = $_POST['password'] ?? '';
    $confirm   = $_POST['confirm_password'] ?? '';

    // Validations
    if (empty($documento) || empty($nombre) || empty($apellidos) || empty($correo) || empty($ciudad) || empty($pais) || empty($password)) {
        $error = 'Por favor complete todos los campos del formulario.';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = 'Por favor ingrese un formato de correo electrónico válido.';
    } elseif (strlen($password) < 6) {
        $error = 'La contraseña debe tener al menos 6 caracteres.';
    } elseif ($password !== $confirm) {
        $error = 'Las contraseñas no coinciden.';
    } else {
        $db = getDBConnection();
        
        // Check if documento or correo already exists
        $checkStmt = $db->prepare("SELECT id FROM usuarios WHERE documento = ? OR correo = ?");
        $checkStmt->execute([$documento, $correo]);
        if ($checkStmt->fetch()) {
            $error = 'El número de documento o el correo ya se encuentran registrados.';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO usuarios (documento, nombre, apellidos, correo, ciudad, pais, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
            try {
                $stmt->execute([$documento, $nombre, $apellidos, $correo, $ciudad, $pais, $hashedPassword]);
                $_SESSION['registered_success'] = '¡Registro exitoso! Ahora puedes iniciar sesión.';
                header('Location: login.php');
                exit;
            } catch (PDOException $e) {
                $error = 'Error al registrar el usuario: ' . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario - <?= APP_NAME ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="navbar">
        <div class="brand">
            <div class="brand-icon">⚡</div>
            <span><?= APP_NAME ?></span>
        </div>
        <div>
            <a href="login.php" style="font-weight: 600;">¿Ya tienes cuenta? Iniciar Sesión</a>
        </div>
    </header>

    <main class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-header">
                <h2>Registro de Usuario</h2>
                <p>Crea tu cuenta para acceder a promociones exclusivas</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <span>⚠️</span> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="register.php" method="POST" id="registerForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="documento">Nº de Documento</label>
                        <input type="text" id="documento" name="documento" class="input-control" placeholder="Ej: 1098765432" value="<?= htmlspecialchars($_POST['documento'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="correo">Correo Electrónico</label>
                        <input type="email" id="correo" name="correo" class="input-control" placeholder="usuario@ejemplo.com" value="<?= htmlspecialchars($_POST['correo'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="input-control" placeholder="Ej: Carlos" value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" id="apellidos" name="apellidos" class="input-control" placeholder="Ej: Mendoza" value="<?= htmlspecialchars($_POST['apellidos'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" id="ciudad" name="ciudad" class="input-control" placeholder="Ej: Bogotá" value="<?= htmlspecialchars($_POST['ciudad'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="pais">País</label>
                        <input type="text" id="pais" name="pais" class="input-control" placeholder="Ej: Colombia" value="<?= htmlspecialchars($_POST['pais'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" class="input-control" placeholder="Mínimo 6 caracteres" required>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirmar Contraseña</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="input-control" placeholder="Repite tu contraseña" required>
                    </div>
                </div>

                <button type="submit" class="btn-primary" style="margin-top: 1.5rem;">
                    Crear Cuenta y Ver Ofertas
                </button>
            </form>
        </div>
    </main>

    <footer class="footer">
        Taller DevOps - Orientado a Buscar la Calidad en el Desarrollo de Software &copy; <?= date('Y') ?>
    </footer>

    <script src="assets/js/app.js"></script>
</body>
</html>
