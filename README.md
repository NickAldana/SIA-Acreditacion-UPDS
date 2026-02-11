SIA - UPDS Santa Cruz (Sistema de Información para la Acreditación)

El SIA es una plataforma integral desarrollada para el Vicerrectorado de la UPDS, diseñada para centralizar, gestionar y auditar la información necesaria para los procesos de acreditación universitaria. El sistema abarca desde la gestión de talento humano hasta la producción científica y carga académica.
🛠️ Stack Tecnológico

    Backend: Laravel 10/11 

    Base de Datos: MySQL con soporte para relaciones N:M 

    Frontend: Blade, Bootstrap 5, Alpine.js y Bootstrap Icons.

    Seguridad: RBAC (Role-Based Access Control) con 13 permisos granulares.

🚀 Instalación y Configuración

Siga estos pasos para desplegar el entorno de desarrollo local:
1. Clonar y Preparar Dependencias
Bash

git clone <url-del-repositorio>
cd sia-upds
composer install
npm install && npm run build

2. Configuración de Entorno

Cree su archivo de configuración local:
Bash

cp .env.example .env
php artisan key:generate

Asegúrese de configurar sus credenciales de base de datos en el archivo .env.
3. Base de Datos (Punto Crítico) ⚠️

Debido a la relación circular (Huevo-Gallina) entre las tablas usuario y Personal, es obligatorio ejecutar el seeder para poblar los registros maestros y el acceso administrativo:
Bash

php artisan migrate:fresh --seed

🔑 Acceso Administrativo (God Mode)

Para ingresar al sistema y visualizar todas las funciones del Módulo de Seguridad y BI, utilice las siguientes credenciales:

    Usuario: sc.ernesto.soto.r@upds.net.bo

    Contraseña: password

📋 Módulos Implementados (V5.0)

    Seguridad: Gestión de usuarios con hash de contraseñas y matriz de permisos jerárquica (0-100).

    Recursos Humanos: Registro de personal, expediente digital con carga de títulos en PDF y gestión de formación académica.

    Carga Académica: Algoritmo de sugerencia de grupos y asignación dinámica de materias.

    Investigación y Publicaciones: Control de proyectos con roles de investigador y vinculación automática de autoría científica.

    Analítica (BI): Dashboard con KPIs estratégicos para el control de indicadores de acreditación.

⚖️ Reglas de Negocio Destacadas

    Protección Jerárquica: Un usuario no puede gestionar a otro con un nivel jerárquico superior.

    Integridad de Títulos: Validación obligatoria de documentos PDF para formación docente (Límite 5MB).

    Unicidad de Grupos: Algoritmo para evitar el solapamiento de grupos en la carga académica.