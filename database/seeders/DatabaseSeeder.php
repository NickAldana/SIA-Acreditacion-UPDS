<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llamamos a nuestros Seeders en orden estricto de dependencia
        $this->call([
            // 1. Catálogos Base (Facultades, Cargos, Roles, etc.)
            GeneralSeeder::class,

            // 2. Estructura Académica (Carreras y Materias)
            // Depende de: Facultades
            AcademicoSeeder::class,

            // 3. Usuarios y Personal (Docentes, Títulos, Cuentas)
            // Depende de: Cargos, Grados, Tipos Contrato
            PersonalSeeder::class,

            // 4. Investigación (Proyectos, Publicaciones y Asignaciones)
            // Depende de: Personal, Carreras, Líneas Inv.
            InvestigacionSeeder::class,
        ]);
    }
}