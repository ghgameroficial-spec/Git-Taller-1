@echo off
title DevOps Shop & Promos - Servidor de Prueba
echo ====================================================
echo   Iniciando DevOps Shop & Promos (Taller DevOps)
echo ====================================================
echo.

where php >nul 2>nul
if %errorlevel% neq 0 (
    echo [ERROR] PHP no se encuentra instalado o no esta agregado al PATH del sistema.
    echo Por favor instale PHP para ejecutar la aplicacion.
    pause
    exit /b
)

echo [OK] Entorno PHP detectado.
echo.
echo ====================================================
echo   CREDENCIALES DE PRUEBA PARA INICIAR SESION:
echo   1. Correo: ghgameroficial@gmail.com  ^| Clave: devops123
echo   2. Correo: juan.perez@devops.com      ^| Clave: devops123
echo   3. Correo: admin@devops.com           ^| Clave: admin123
echo ====================================================
echo.
echo Servidor iniciado en http://localhost:8000
echo Abriendo navegador web...
echo.

start http://localhost:8000/login.php
php -S localhost:8000
