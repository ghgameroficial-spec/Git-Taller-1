<?php
require_once __DIR__ . '/config.php';

function getDBConnection() {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    try {
        if (DB_DRIVER === 'sqlite') {
            $firstTime = !file_exists(SQLITE_FILE);
            $pdo = new PDO('sqlite:' . SQLITE_FILE);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            if ($firstTime) {
                initSqliteDatabase($pdo);
            }
        } else {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }
        return $pdo;
    } catch (PDOException $e) {
        die("Error de conexión a la base de datos: " . $e->getMessage());
    }
}

function initSqliteDatabase($pdo) {
    $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        documento TEXT NOT NULL UNIQUE,
        nombre TEXT NOT NULL,
        apellidos TEXT NOT NULL,
        correo TEXT NOT NULL UNIQUE,
        ciudad TEXT NOT NULL,
        pais TEXT NOT NULL,
        password TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS productos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nombre TEXT NOT NULL,
        descripcion TEXT NOT NULL,
        categoria TEXT NOT NULL,
        precio_original REAL NOT NULL,
        descuento_porcentaje INTEGER NOT NULL,
        precio_promocional REAL NOT NULL,
        imagen TEXT NOT NULL,
        badge TEXT DEFAULT '¡PROMO ESPECIAL!',
        stock INTEGER DEFAULT 15,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Seed products if empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM productos");
    if ($stmt->fetchColumn() == 0) {
        $products = [
            [
                'Laptop Pro DevOps Edition 16"',
                'Procesador Intel i9 14ª Gen, 32GB RAM DDR5, 1TB NVMe SSD. Ideal para entornos CI/CD y virtualización.',
                'Tecnología',
                1899.99,
                25,
                1424.99,
                'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=800&q=80',
                'MÁS VENDIDO',
                12
            ],
            [
                'Monitor UltraWide Curved 34"',
                'Pantalla OLED 175Hz 0.1ms 4K HDR10, ángulo ultra panorámico para programación multiventana.',
                'Tecnología',
                899.00,
                30,
                629.30,
                'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=800&q=80',
                'OFERTA FLASH',
                8
            ],
            [
                'Teclado Mecánico RGB Cloud',
                'Switches mecánicos silenciosos sustituibles en caliente, chasis de aluminio pulido y conexión inalámbrica tri-modo.',
                'Accesorios',
                149.50,
                40,
                89.70,
                'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=800&q=80',
                '40% OFF',
                25
            ],
            [
                'Audífonos Noise Cancelling Studio Pro',
                'Cancelación activa de ruido inteligente (ANC), batería de 40 horas y sonido HD Hi-Res.',
                'Audio',
                299.99,
                35,
                194.99,
                'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&q=80',
                'IMPERDIBLE',
                18
            ],
            [
                'Silla Ergonómica DevOps Mesh',
                'Soporte lumbar dinámico 4D, cabezal ajustable y malla ultra transpirable para largas jornadas de código.',
                'Mobiliario',
                450.00,
                20,
                360.00,
                'https://images.unsplash.com/photo-1580481072645-022f9a6d83d0?auto=format&fit=crop&w=800&q=80',
                'CONFORT',
                10
            ],
            [
                'Smartwatch Fitness & Code Tracker',
                'Monitoreo de salud 24/7, notificaciones de commits y despliegues, resistencia al agua 50m.',
                'Wearables',
                199.00,
                50,
                99.50,
                'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=800&q=80',
                '50% OFF',
                30
            ]
        ];

        $ins = $pdo->prepare("INSERT INTO productos (nombre, descripcion, categoria, precio_original, descuento_porcentaje, precio_promocional, imagen, badge, stock) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($products as $p) {
            $ins->execute($p);
        }
    }
}
