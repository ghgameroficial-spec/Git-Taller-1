-- Base de Datos: taller_devops
-- Profesor: John Robert Causimanse

CREATE DATABASE IF NOT EXISTS `taller_devops` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `taller_devops`;

-- Tabla de Usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `documento` VARCHAR(30) NOT NULL UNIQUE,
  `nombre` VARCHAR(80) NOT NULL,
  `apellidos` VARCHAR(80) NOT NULL,
  `correo` VARCHAR(120) NOT NULL UNIQUE,
  `ciudad` VARCHAR(60) NOT NULL,
  `pais` VARCHAR(60) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de Productos en Promoción
CREATE TABLE IF NOT EXISTS `productos` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(150) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `categoria` VARCHAR(60) NOT NULL,
  `precio_original` DECIMAL(10,2) NOT NULL,
  `descuento_porcentaje` INT NOT NULL,
  `precio_promocional` DECIMAL(10,2) NOT NULL,
  `imagen` VARCHAR(255) NOT NULL,
  `badge` VARCHAR(50) DEFAULT '¡PROMO ESPECIAL!',
  `stock` INT DEFAULT 15,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar productos promocionales de prueba
INSERT INTO `productos` (`nombre`, `descripcion`, `categoria`, `precio_original`, `descuento_porcentaje`, `precio_promocional`, `imagen`, `badge`, `stock`) VALUES
('Laptop Pro DevOps Edition 16"', 'Procesador Intel i9 14ª Gen, 32GB RAM DDR5, 1TB NVMe SSD. Ideal para entornos CI/CD y virtualización.', 'Tecnología', 1899.99, 25, 1424.99, 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=800&q=80', 'MÁS VENDIDO', 12),
('Monitor UltraWide Curved 34"', 'Pantalla OLED 175Hz 0.1ms 4K HDR10, ángulo ultra panorámico para programación multiventana.', 'Tecnología', 899.00, 30, 629.30, 'OFERTA FLASH', 8),
('Teclado Mecánico RGB Cloud', 'Switches mecánicos silenciosos sustituibles en caliente, chasis de aluminio pulido y conexión inalámbrica tri-modo.', 'Accesorios', 149.50, 40, 89.70, '40% OFF', 25),
('Audífonos Noise Cancelling Studio Pro', 'Cancelación activa de ruido inteligente (ANC), batería de 40 horas y sonido HD Hi-Res.', 'Audio', 299.99, 35, 194.99, 'IMPERDIBLE', 18),
('Silla Ergonómica DevOps Mesh', 'Soporte lumbar dinámico 4D, cabezal ajustable y malla ultra transpirable para largas jornadas de código.', 'Mobiliario', 450.00, 20, 360.00, 'CONFORT', 10),
('Smartwatch Fitness & Code Tracker', 'Monitoreo de salud 24/7, notificaciones de commits y despliegues, resistencia al agua 50m.', 'Wearables', 199.00, 50, 99.50, '50% OFF', 30);
