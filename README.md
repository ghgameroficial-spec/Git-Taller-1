# ⚡ DevOps Shop & Promos - Taller DevOps

Aplicación Web completa desarrollada para el **Taller DevOps - Orientado a Buscar la Calidad en el Desarrollo de Software** (Profesor: John Robert Causimanse).

---

## 🚀 Requisitos del Sistema
- **PHP 8.x** (probado en PHP 8.2+) con extensión PDO habilitada.
- Navegador Web moderno (Chrome, Edge, Firefox, Safari).

---

## ⚡ Ejecución Rápida en 1 Clic

### En Windows:
Simplemente haz doble clic sobre el archivo **`run.bat`** o ejecútalo desde PowerShell:
```cmd
run.bat
```

### En Linux / macOS:
Otorga permisos de ejecución e inicia el script **`run.sh`**:
```bash
chmod +x run.sh
./run.sh
```

El script abrirá automáticamente la aplicación en tu navegador en:
👉 **[http://localhost:8000](http://localhost:8000)**

---

## 🔑 Credenciales de Prueba Preconfiguradas

Puedes iniciar sesión con cualquiera de los siguientes usuarios:

| Correo / Documento | Contraseña | Nombre | Rol |
| :--- | :--- | :--- | :--- |
| **`ghgameroficial@gmail.com`** | `devops123` | GH Gamer | Usuario |
| **`juan.perez@devops.com`** | `devops123` | Juan Pérez | Usuario |
| **`admin@devops.com`** | `admin123` | Carlos Gómez | Usuario |

*También puedes registrar nuevos usuarios en el enlace de registro del sitio.*

---

## 🛠️ Ejecución Manual desde Consola

Si prefieres ejecutar el servidor manualmente:

```bash
# 1. Abre una consola en esta carpeta
cd "ruta/a/Primer taller"

# 2. Inicia el servidor PHP
php -S localhost:8000

# 3. Abre en tu navegador:
http://localhost:8000
```

---

## 📂 Estructura de Archivos del Proyecto

- `run.bat` / `run.sh`: Ejecutables para inicio automático del servidor.
- `index.php`: Enrutador principal.
- `register.php`: Módulo de registro con 6 campos obligatorios y validaciones.
- `login.php`: Módulo de autenticación segura.
- `catalog.php`: Catálogo interactivo de promociones con buscador y filtros por categoría.
- `logout.php`: Destrucción de sesión.
- `config.php`: Variables globales de configuración.
- `db.php`: Capa de datos PDO (soporta SQLite por defecto y MySQL).
- `schema.sql`: Script DDL/DML para base de datos MySQL en producción.
- `assets/css/style.css`: Sistema de diseño moderno Glassmorphism.
- `assets/js/app.js`: Filtrado en tiempo real y validaciones.
- `Taller SinDevOps.pdf`: Documento guía de la actividad.

---

## 📊 Módulos Implementados según la Guía

1. **Registro de Usuario**: Número de documento, Nombre, Apellidos, Correo, Ciudad, País y Contraseña.
2. **Autenticación (Login)**: Verificación segura con `password_verify` y sesión PHP.
3. **Catálogo de Promociones**: Filtros interactivos por categoría, buscador en vivo, precios con descuento y badges.
4. **Persistencia Adaptativa**: SQLite listo sin configuración previa + `schema.sql` listo para MySQL.
