#!/usr/bin/env bash

echo "===================================================="
echo "  Iniciando DevOps Shop & Promos (Taller DevOps)    "
echo "===================================================="
echo ""

if ! command -v php &> /dev/null; then
    echo "[ERROR] PHP no está instalado en el sistema."
    exit 1
fi

echo "[OK] Entorno PHP detectado."
echo ""
echo "===================================================="
echo "  CREDENCIALES DE PRUEBA PARA INICIAR SESIÓN:"
echo "  1. Correo: ghgameroficial@gmail.com  | Clave: devops123"
echo "  2. Correo: juan.perez@devops.com      | Clave: devops123"
echo "  3. Correo: admin@devops.com           | Clave: admin123"
echo "===================================================="
echo ""
echo "Servidor iniciado en http://localhost:8000"
echo "Presione Ctrl+C para finalizar."
echo ""

if command -v xdg-open &> /dev/null; then
    xdg-open "http://localhost:8000/login.php" &
elif command -v open &> /dev/null; then
    open "http://localhost:8000/login.php" &
fi

php -S localhost:8000
