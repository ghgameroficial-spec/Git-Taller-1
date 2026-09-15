<?php
require_once __DIR__ . '/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: catalog.php');
    exit;
}

$error = '';
$success = '';

if (isset($_SESSION['registered_success'])) {
    $success = $_SESSION['registered_success'];
    unset($_SESSION['registered_success']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $credential = trim($_POST['credential'] ?? '');
    $password   = $_POST['password'] ?? '';

    if (empty($credential) || empty($password)) {
        $error = 'Por favor ingrese sus credenciales y contraseña.';
    } else {
        $db = getDBConnection();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE correo = ? OR documento = ? LIMIT 1");
        $stmt->execute([$credential, $credential]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']        = $user['id'];
            $_SESSION['user_name']      = $user['nombre'];
            $_SESSION['user_lastname']  = $user['apellidos'];
            $_SESSION['user_email']     = $user['correo'];
            $_SESSION['user_documento'] = $user['documento'];
            
            header('Location: catalog.php');
            exit;
        } else {
            $error = 'Credenciales o contraseña incorrectas.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - <?= APP_NAME ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="navbar">
        <div class="brand">
            <div class="brand-icon">⚡</div>
            <span><?= APP_NAME ?></span>
        </div>
        <div>
            <a href="register.php" style="font-weight: 600;">¿No tienes cuenta? Regístrate</a>
        </div>
    </header>

    <main class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-header">
                <h2>Iniciar Sesión</h2>
                <p>Ingresa tus credenciales para acceder a la plataforma</p>
            </div>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <span>✅</span> <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <span>⚠️</span> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="credential">Correo Electrónico o Nº de Documento</label>
                    <input type="text" id="credential" name="credential" class="input-control" placeholder="Ej: usuario@ejemplo.com o 1098765432" value="<?= htmlspecialchars($_POST['credential'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" class="input-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-primary" style="margin-top: 1.5rem;">
                    Ingresar a la Plataforma
                </button>
            </form>

            <div style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: var(--text-muted);">
                ¿Nuevo por aquí? <a href="register.php">Regístrate gratis</a>
            </div>
        </div>
    </main>

    <footer class="footer">
        Taller DevOps - Orientado a Buscar la Calidad en el Desarrollo de Software &copy; <?= date('Y') ?>
    </footer>

    <script src="assets/js/app.js"></script>
</body>
</html>
