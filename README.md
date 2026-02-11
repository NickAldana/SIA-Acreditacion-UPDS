SIA - UPDS Santa Cruz (Sistema de Información para la Acreditación)

El SIA es una plataforma integral desarrollada para el Vicerrectorado de la UPDS. Está diseñada para centralizar, gestionar y auditar la información necesaria para los procesos de acreditación universitaria.
📋 Requisitos del Sistema

Para que el sistema funcione correctamente en el host o entorno local, se requiere:

    Lenguaje: PHP 8.2.28 o superior.

    Base de Datos: MySQL 8.0+.

    Extensiones PHP: bcmath, ctype, fileinfo, openssl, pdo_mysql.

🛠️ Stack Tecnológico

    Backend: Laravel 12.49.0 (Última versión estable).

    Base de Datos: MySQL con soporte para relaciones N:M.

    Frontend: Blade, Bootstrap 5, Alpine.js y Bootstrap Icons.

    Seguridad: RBAC (Role-Based Access Control) con 13 permisos granulares.

🚀 Instalación y Configuración
1. Clonar y Preparar Dependencias
Bash

git clone https://github.com/NickAldana/SIA-Acreditacion-UPDS.git
cd SIA-Acreditacion-UPDS
composer install
npm install && npm run build

2. Configuración de Entorno
Bash

cp .env.example .env
php artisan key:generate

Configure sus credenciales de base de datos en el archivo .env.
3. Base de Datos (Punto Crítico) ⚠️

Debido a la relación circular entre las tablas usuario y Personal, es obligatorio ejecutar el seeder para poblar los registros maestros:
Bash

php artisan migrate:fresh --seed

🔑 Acceso Administrativo (God Mode)

Para ingresar al sistema con el cargo de Director de Acreditación y acceso total:

    Usuario: sc.ernesto.soto.r@upds.net.bo

    Contraseña: password

📋 Módulos Implementados (V5.0)

    Seguridad: Gestión de usuarios con hash Bcrypt y matriz jerárquica (Niveles 0-100).

    Recursos Humanos: Registro de personal, expediente digital y gestión de formación con carga de PDF.

    Carga Académica: Algoritmo de sugerencia de grupos y asignación dinámica de materias.

    Investigación: Control de proyectos (23 líneas de investigación) y vinculación de autoría.

    Analítica (BI): Dashboard con KPIs estratégicos para el Rector y Acreditadores.

⚖️ Reglas de Negocio Destacadas

    Protección Jerárquica: Un usuario no puede gestionar perfiles con un nivel jerárquico superior al suyo.

    Integridad de Títulos: Validación obligatoria de documentos PDF (Límite 5MB) para formación docente.

    Unicidad de Grupos: Algoritmo para evitar el solapamiento de grupos en la carga académica.

Desarrollado para el Vicerrectorado UPDS - Santa Cruz, Bolivia.
