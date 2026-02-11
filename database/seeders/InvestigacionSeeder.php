<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvestigacionSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. PROYECTOS DE INVESTIGACIÓN
        // ==========================================
        $proyectos = [
            ['ProyectoinvestigacionID' => 1, 'CodigoProyecto' => 'RA-INV', 'Nombreproyecto' => 'REALIDAD AUMENTADA Y SU USO EN EL ENTORNO EDUCATIVO', 'Fechainicio' => '2026-02-03', 'Fechafinalizacion' => null, 'Estado' => 'En Ejecución', 'CarreraID' => 1, 'LineainvestigacionID' => 18],
            ['ProyectoinvestigacionID' => 2, 'CodigoProyecto' => 'INV-GA', 'Nombreproyecto' => 'ROBOTICA Y SU USO EN LA AUTOMATIZACION', 'Fechainicio' => '2026-02-04', 'Fechafinalizacion' => null, 'Estado' => 'En Ejecución', 'CarreraID' => 3, 'LineainvestigacionID' => 1],
            ['ProyectoinvestigacionID' => 3, 'CodigoProyecto' => 'INV-2026-001', 'Nombreproyecto' => 'METODOS DE CONSERVACION DEL ECOSISTEMA USANDO TECINCAS DE AUTOSUFICIENCIA SIN FINES DE LUCRO', 'Fechainicio' => '2026-02-03', 'Fechafinalizacion' => null, 'Estado' => 'En Ejecución', 'CarreraID' => 15, 'LineainvestigacionID' => 21],
            ['ProyectoinvestigacionID' => 4, 'CodigoProyecto' => 'INV-2026-002', 'Nombreproyecto' => 'REALIDAD OCUPACIONAL EN SISTEMAS ERP', 'Fechainicio' => '2026-02-03', 'Fechafinalizacion' => null, 'Estado' => 'Planificado', 'CarreraID' => 7, 'LineainvestigacionID' => 5],
            ['ProyectoinvestigacionID' => 5, 'CodigoProyecto' => 'INV-2026-003', 'Nombreproyecto' => 'FASFAFASF', 'Fechainicio' => '2026-02-03', 'Fechafinalizacion' => null, 'Estado' => 'En Ejecución', 'CarreraID' => 18, 'LineainvestigacionID' => 1],
            ['ProyectoinvestigacionID' => 6, 'CodigoProyecto' => 'INV-2026-004', 'Nombreproyecto' => 'PROPUESTA', 'Fechainicio' => '2026-02-04', 'Fechafinalizacion' => '2026-02-03', 'Estado' => 'Finalizado', 'CarreraID' => 7, 'LineainvestigacionID' => 1],
            ['ProyectoinvestigacionID' => 7, 'CodigoProyecto' => 'INV-2026-005', 'Nombreproyecto' => 'PRESSIOOOOO', 'Fechainicio' => '2026-02-11', 'Fechafinalizacion' => null, 'Estado' => 'Planificado', 'CarreraID' => 7, 'LineainvestigacionID' => 19],
            ['ProyectoinvestigacionID' => 8, 'CodigoProyecto' => 'INV-2026-006', 'Nombreproyecto' => 'RESSS', 'Fechainicio' => '2026-02-03', 'Fechafinalizacion' => null, 'Estado' => 'En Ejecución', 'CarreraID' => 14, 'LineainvestigacionID' => 1],
            ['ProyectoinvestigacionID' => 9, 'CodigoProyecto' => 'INV-2026-007', 'Nombreproyecto' => 'AAAA', 'Fechainicio' => '2026-02-03', 'Fechafinalizacion' => null, 'Estado' => 'Planificado', 'CarreraID' => 14, 'LineainvestigacionID' => 4],
            ['ProyectoinvestigacionID' => 10, 'CodigoProyecto' => 'INV-2026-008', 'Nombreproyecto' => 'EE', 'Fechainicio' => '2026-02-03', 'Fechafinalizacion' => null, 'Estado' => 'En Ejecución', 'CarreraID' => 14, 'LineainvestigacionID' => 2],
            ['ProyectoinvestigacionID' => 11, 'CodigoProyecto' => 'INV-2026-009', 'Nombreproyecto' => 'CRIPTOLOGIA Y METODOS DE SEGURIDAD EN REDES CONVERGENTES', 'Fechainicio' => '2026-02-04', 'Fechafinalizacion' => '2026-02-03', 'Estado' => 'Finalizado', 'CarreraID' => 2, 'LineainvestigacionID' => 2],
            ['ProyectoinvestigacionID' => 12, 'CodigoProyecto' => 'INV-2026-010', 'Nombreproyecto' => 'ESTUDIO PRAGAMATICO DE LA EDUCACION EN EL AMBITO UNIVERSITARIO', 'Fechainicio' => '2026-02-03', 'Fechafinalizacion' => null, 'Estado' => 'Planificado', 'CarreraID' => 6, 'LineainvestigacionID' => 8],
            ['ProyectoinvestigacionID' => 13, 'CodigoProyecto' => 'INV-2026-011', 'Nombreproyecto' => 'PRUEBA155566', 'Fechainicio' => '2026-02-04', 'Fechafinalizacion' => null, 'Estado' => 'En Ejecución', 'CarreraID' => 7, 'LineainvestigacionID' => 1],
            ['ProyectoinvestigacionID' => 14, 'CodigoProyecto' => 'INV-2026-012', 'Nombreproyecto' => 'CAPITALIZACION', 'Fechainicio' => '2026-02-04', 'Fechafinalizacion' => null, 'Estado' => 'En Ejecución', 'CarreraID' => 7, 'LineainvestigacionID' => 1],
            ['ProyectoinvestigacionID' => 15, 'CodigoProyecto' => 'INV-2026-013', 'Nombreproyecto' => 'REALIDAD OCUPACIONAL EN SISTEMAS ERP', 'Fechainicio' => '2026-02-04', 'Fechafinalizacion' => null, 'Estado' => 'En Ejecución', 'CarreraID' => 1, 'LineainvestigacionID' => 1],
            ['ProyectoinvestigacionID' => 16, 'CodigoProyecto' => 'INV-2026-014', 'Nombreproyecto' => 'PROPUESTA DE VALOR', 'Fechainicio' => '2026-02-04', 'Fechafinalizacion' => null, 'Estado' => 'En Ejecución', 'CarreraID' => 16, 'LineainvestigacionID' => 18],
            ['ProyectoinvestigacionID' => 17, 'CodigoProyecto' => 'INV-2026-015', 'Nombreproyecto' => 'ETL DE SISTEMAS EN BI', 'Fechainicio' => '2026-02-04', 'Fechafinalizacion' => null, 'Estado' => 'En Ejecución', 'CarreraID' => 1, 'LineainvestigacionID' => 14],
            ['ProyectoinvestigacionID' => 18, 'CodigoProyecto' => 'INV-2026-016', 'Nombreproyecto' => 'LA ILIADAAAAA', 'Fechainicio' => '2026-02-04', 'Fechafinalizacion' => null, 'Estado' => 'Planificado', 'CarreraID' => 18, 'LineainvestigacionID' => 18],
            ['ProyectoinvestigacionID' => 19, 'CodigoProyecto' => 'INV-2026-017', 'Nombreproyecto' => 'AAAAAAAAAAAAAAAA', 'Fechainicio' => '2026-02-04', 'Fechafinalizacion' => '2026-02-04', 'Estado' => 'Cancelado', 'CarreraID' => 6, 'LineainvestigacionID' => 15],
            ['ProyectoinvestigacionID' => 20, 'CodigoProyecto' => 'INV-2026-018', 'Nombreproyecto' => 'ANALISIS DE IMPACTO EDUCATIVO EN ENTORNOS RURALES', 'Fechainicio' => '2026-02-04', 'Fechafinalizacion' => null, 'Estado' => 'En Ejecución', 'CarreraID' => 13, 'LineainvestigacionID' => 22],
            ['ProyectoinvestigacionID' => 21, 'CodigoProyecto' => 'INV-2026-019', 'Nombreproyecto' => 'PROYECTO PRUEBA', 'Fechainicio' => '2026-02-04', 'Fechafinalizacion' => null, 'Estado' => 'En Ejecución', 'CarreraID' => 1, 'LineainvestigacionID' => 23],
            ['ProyectoinvestigacionID' => 22, 'CodigoProyecto' => 'INV-2026-020', 'Nombreproyecto' => 'ASDAAASDASDASD', 'Fechainicio' => '2026-02-06', 'Fechafinalizacion' => null, 'Estado' => 'Planificado', 'CarreraID' => 7, 'LineainvestigacionID' => 2],
        ];

        DB::table('Proyectoinvestigacion')->insertOrIgnore($proyectos);

        // ==========================================
        // 2. PARTICIPACIÓN PERSONAL-PROYECTO
        // ==========================================
        $personalProyectos = [
            ['PersonalproyectoID' => 1, 'Rol' => 'TUTOR / ASESOR', 'PersonalID' => 28, 'ProyectoinvestigacionID' => 2, 'EsResponsable' => 0, 'FechaInicio' => '2026-02-04', 'FechaFin' => null],
            ['PersonalproyectoID' => 3, 'Rol' => null, 'PersonalID' => 82, 'ProyectoinvestigacionID' => 3, 'EsResponsable' => 1, 'FechaInicio' => '2026-02-03', 'FechaFin' => null],
            ['PersonalproyectoID' => 4, 'Rol' => null, 'PersonalID' => 84, 'ProyectoinvestigacionID' => 3, 'EsResponsable' => 0, 'FechaInicio' => '2026-02-03', 'FechaFin' => null],
            ['PersonalproyectoID' => 5, 'Rol' => null, 'PersonalID' => 28, 'ProyectoinvestigacionID' => 3, 'EsResponsable' => 1, 'FechaInicio' => '2026-02-03', 'FechaFin' => null],
            ['PersonalproyectoID' => 6, 'Rol' => 'ENCARGADO DE PROYECTO', 'PersonalID' => 25, 'ProyectoinvestigacionID' => 2, 'EsResponsable' => 0, 'FechaInicio' => '2026-02-04', 'FechaFin' => '2026-02-05'],
            ['PersonalproyectoID' => 7, 'Rol' => 'ENCARGADO DE PROYECTO', 'PersonalID' => 49, 'ProyectoinvestigacionID' => 4, 'EsResponsable' => 1, 'FechaInicio' => '2026-02-03', 'FechaFin' => null],
            ['PersonalproyectoID' => 8, 'Rol' => null, 'PersonalID' => 49, 'ProyectoinvestigacionID' => 5, 'EsResponsable' => 1, 'FechaInicio' => '2026-02-03', 'FechaFin' => null],
            ['PersonalproyectoID' => 12, 'Rol' => 'PASANTE', 'PersonalID' => 1, 'ProyectoinvestigacionID' => 6, 'EsResponsable' => 0, 'FechaInicio' => '2026-02-04', 'FechaFin' => null],
            ['PersonalproyectoID' => 15, 'Rol' => null, 'PersonalID' => 18, 'ProyectoinvestigacionID' => 8, 'EsResponsable' => 1, 'FechaInicio' => '2026-02-03', 'FechaFin' => null],
            ['PersonalproyectoID' => 16, 'Rol' => null, 'PersonalID' => 87, 'ProyectoinvestigacionID' => 8, 'EsResponsable' => 0, 'FechaInicio' => '2026-02-03', 'FechaFin' => null],
            ['PersonalproyectoID' => 17, 'Rol' => 'ENCARGADO DE PROYECTO', 'PersonalID' => 78, 'ProyectoinvestigacionID' => 9, 'EsResponsable' => 1, 'FechaInicio' => '2026-02-03', 'FechaFin' => null],
            ['PersonalproyectoID' => 18, 'Rol' => 'REVISOR TÉCNICO', 'PersonalID' => 73, 'ProyectoinvestigacionID' => 10, 'EsResponsable' => 0, 'FechaInicio' => '2026-02-03', 'FechaFin' => null],
            ['PersonalproyectoID' => 19, 'Rol' => 'PASANTE', 'PersonalID' => 14, 'ProyectoinvestigacionID' => 11, 'EsResponsable' => 1, 'FechaInicio' => '2026-02-04', 'FechaFin' => '2026-02-18'],
            ['PersonalproyectoID' => 20, 'Rol' => 'ENCARGADO DE PROYECTO', 'PersonalID' => 49, 'ProyectoinvestigacionID' => 12, 'EsResponsable' => 1, 'FechaInicio' => '2026-02-03', 'FechaFin' => null],
            ['PersonalproyectoID' => 21, 'Rol' => 'ENCARGADO DE PROYECTO', 'PersonalID' => 87, 'ProyectoinvestigacionID' => 12, 'EsResponsable' => 1, 'FechaInicio' => '2026-02-03', 'FechaFin' => null],
            ['PersonalproyectoID' => 22, 'Rol' => 'DOCENTE INVESTIGADOR', 'PersonalID' => 14, 'ProyectoinvestigacionID' => 12, 'EsResponsable' => 0, 'FechaInicio' => '2026-02-03', 'FechaFin' => null],
            ['PersonalproyectoID' => 23, 'Rol' => 'ENCARGADO DE PROYECTO', 'PersonalID' => 45, 'ProyectoinvestigacionID' => 13, 'EsResponsable' => 0, 'FechaInicio' => '2026-02-04', 'FechaFin' => null],
            ['PersonalproyectoID' => 24, 'Rol' => 'ENCARGADO DE PROYECTO', 'PersonalID' => 49, 'ProyectoinvestigacionID' => 13, 'EsResponsable' => 1, 'FechaInicio' => '2026-02-04', 'FechaFin' => null],
            ['PersonalproyectoID' => 25, 'Rol' => 'TUTOR / ASESOR', 'PersonalID' => 14, 'ProyectoinvestigacionID' => 13, 'EsResponsable' => 0, 'FechaInicio' => '2026-02-04', 'FechaFin' => '2026-02-04'],
            ['PersonalproyectoID' => 26, 'Rol' => 'ENCARGADO DE PROYECTO', 'PersonalID' => 1, 'ProyectoinvestigacionID' => 14, 'EsResponsable' => 1, 'FechaInicio' => '2026-02-04', 'FechaFin' => null],
            ['PersonalproyectoID' => 27, 'Rol' => 'DOCENTE INVESTIGADOR', 'PersonalID' => 49, 'ProyectoinvestigacionID' => 14, 'EsResponsable' => 0, 'FechaInicio' => '2026-02-04', 'FechaFin' => null],
            ['PersonalproyectoID' => 32, 'Rol' => 'ENCARGADO DE PROYECTO', 'PersonalID' => 82, 'ProyectoinvestigacionID' => 17, 'EsResponsable' => 1, 'FechaInicio' => '2026-02-04', 'FechaFin' => null],
            ['PersonalproyectoID' => 33, 'Rol' => 'REVISOR TÉCNICO', 'PersonalID' => 28, 'ProyectoinvestigacionID' => 18, 'EsResponsable' => 1, 'FechaInicio' => '2026-02-04', 'FechaFin' => null],
            ['PersonalproyectoID' => 34, 'Rol' => 'DOCENTE INVESTIGADOR', 'PersonalID' => 82, 'ProyectoinvestigacionID' => 18, 'EsResponsable' => 0, 'FechaInicio' => '2026-02-04', 'FechaFin' => null],
            ['PersonalproyectoID' => 35, 'Rol' => 'ENCARGADO DE PROYECTO', 'PersonalID' => 82, 'ProyectoinvestigacionID' => 19, 'EsResponsable' => 1, 'FechaInicio' => '2026-02-04', 'FechaFin' => '2026-02-04'],
            ['PersonalproyectoID' => 36, 'Rol' => 'ENCARGADO DE PROYECTO', 'PersonalID' => 13, 'ProyectoinvestigacionID' => 19, 'EsResponsable' => 1, 'FechaInicio' => '2026-02-04', 'FechaFin' => '2026-02-04'],
            ['PersonalproyectoID' => 37, 'Rol' => 'ESTUDIANTE INVESTIGADOR', 'PersonalID' => 2, 'ProyectoinvestigacionID' => 2, 'EsResponsable' => 0, 'FechaInicio' => '2026-02-04', 'FechaFin' => null],
            ['PersonalproyectoID' => 52, 'Rol' => 'REVISOR TÉCNICO', 'PersonalID' => 37, 'ProyectoinvestigacionID' => 21, 'EsResponsable' => 0, 'FechaInicio' => '2026-02-05', 'FechaFin' => '2026-02-05'],
            ['PersonalproyectoID' => 53, 'Rol' => 'ENCARGADO DE PROYECTO', 'PersonalID' => 82, 'ProyectoinvestigacionID' => 21, 'EsResponsable' => 1, 'FechaInicio' => '2026-02-05', 'FechaFin' => null],
            ['PersonalproyectoID' => 54, 'Rol' => 'ENCARGADO DE PROYECTO', 'PersonalID' => 28, 'ProyectoinvestigacionID' => 1, 'EsResponsable' => 1, 'FechaInicio' => '2026-02-05', 'FechaFin' => null],
            ['PersonalproyectoID' => 55, 'Rol' => 'DOCENTE INVESTIGADOR', 'PersonalID' => 45, 'ProyectoinvestigacionID' => 7, 'EsResponsable' => 0, 'FechaInicio' => '2026-02-11', 'FechaFin' => '2026-02-13'],
        ];

        DB::table('Personalproyecto')->insertOrIgnore($personalProyectos);

        // ==========================================
        // 3. PUBLICACIONES
        // ==========================================
        $publicaciones = [
            ['PublicacionID' => 11, 'Nombrepublicacion' => 'INTELIGENCIA ARTIFICIAL GENERATIVA EN LA EDUCACIÓN SUPERIOR BOLIVIANA', 'Fechapublicacion' => '2025-02-15', 'MediopublicacionID' => 1, 'ProyectoinvestigacionID' => null, 'TipopublicacionID' => 1, 'RutaArchivo' => null, 'UrlPublicacion' => null, 'LineainvestigacionID' => null],
            ['PublicacionID' => 12, 'Nombrepublicacion' => 'MANUAL DE DERECHO CONSTITUCIONAL Y PROCEDIMIENTOS LEGISLATIVOS', 'Fechapublicacion' => '2024-11-10', 'MediopublicacionID' => 8, 'ProyectoinvestigacionID' => null, 'TipopublicacionID' => 2, 'RutaArchivo' => null, 'UrlPublicacion' => null, 'LineainvestigacionID' => null],
            ['PublicacionID' => 13, 'Nombrepublicacion' => 'SISTEMA DE FILTRADO DE AGUAS RESIDUALES MEDIANTE SENSORES IOT DE BAJO COSTO', 'Fechapublicacion' => '2026-01-20', 'MediopublicacionID' => 3, 'ProyectoinvestigacionID' => null, 'TipopublicacionID' => 12, 'RutaArchivo' => null, 'UrlPublicacion' => null, 'LineainvestigacionID' => null],
            ['PublicacionID' => 14, 'Nombrepublicacion' => 'MODELO DE GESTIÓN DE COMPETITIVIDAD PARA PYMES EN SANTA CRUZ', 'Fechapublicacion' => '2023-12-05', 'MediopublicacionID' => 12, 'ProyectoinvestigacionID' => null, 'TipopublicacionID' => 11, 'RutaArchivo' => null, 'UrlPublicacion' => null, 'LineainvestigacionID' => null],
            ['PublicacionID' => 15, 'Nombrepublicacion' => 'FRAMEWORK PARA EL DESARROLLO ÁGIL EN ENTORNOS EDUCATIVOS', 'Fechapublicacion' => '2026-03-01', 'MediopublicacionID' => 4, 'ProyectoinvestigacionID' => null, 'TipopublicacionID' => 1, 'RutaArchivo' => null, 'UrlPublicacion' => null, 'LineainvestigacionID' => 1],
            ['PublicacionID' => 16, 'Nombrepublicacion' => 'RA INVESTIGACION CIENTIFICA EN EL ENTORNO EDUCATIVO', 'Fechapublicacion' => '2026-02-04', 'MediopublicacionID' => 10, 'ProyectoinvestigacionID' => 1, 'TipopublicacionID' => 1, 'RutaArchivo' => null, 'UrlPublicacion' => 'https://info.orcid.org/es/', 'LineainvestigacionID' => 1],
            ['PublicacionID' => 17, 'Nombrepublicacion' => 'ANALISIS DE MERCADOS EMERGENTES EN LA BOLSA DE VALORES', 'Fechapublicacion' => '2026-02-04', 'MediopublicacionID' => 8, 'ProyectoinvestigacionID' => null, 'TipopublicacionID' => 5, 'RutaArchivo' => null, 'UrlPublicacion' => null, 'LineainvestigacionID' => null],
            ['PublicacionID' => 18, 'Nombrepublicacion' => 'BLOCKCAHIN EN EL AMBITO DE LAS CRIPTOMONEDAS', 'Fechapublicacion' => '2026-02-04', 'MediopublicacionID' => 7, 'ProyectoinvestigacionID' => null, 'TipopublicacionID' => 4, 'RutaArchivo' => 'evidencias/aI308BOgBf3U2CiF3USx7vCmPuRj5vOosSo6aBGh.pdf', 'UrlPublicacion' => null, 'LineainvestigacionID' => 18],
            ['PublicacionID' => 19, 'Nombrepublicacion' => 'ROBOTICA AUTOMATIZADA EN EL ENTORNO LABORAL', 'Fechapublicacion' => '2026-02-04', 'MediopublicacionID' => 1, 'ProyectoinvestigacionID' => 2, 'TipopublicacionID' => 1, 'RutaArchivo' => null, 'UrlPublicacion' => 'https://info.orcid.org/es/documentation/api-tutorials/api-tutorial-read-data-on-a-record/', 'LineainvestigacionID' => 3],
            ['PublicacionID' => 20, 'Nombrepublicacion' => 'ANALISIS DE IMPACTO EDUCATIVO EN ENTORNOS RURALES', 'Fechapublicacion' => '2026-02-04', 'MediopublicacionID' => 1, 'ProyectoinvestigacionID' => 20, 'TipopublicacionID' => 1, 'RutaArchivo' => 'evidencias_publicaciones/x62gsHWo7Fodm39dKKrHMrebWk2ivD4NvFvdBWgq.pdf', 'UrlPublicacion' => null, 'LineainvestigacionID' => 22],
        ];

        DB::table('Publicacion')->insertOrIgnore($publicaciones);

        // ==========================================
        // 4. AUTORES DE PUBLICACIONES
        // ==========================================
        $personalPublicacion = [
            ['PersonalpublicacionID' => 18, 'RolID' => 6, 'PersonalID' => 7, 'PublicacionID' => 16],
            ['PersonalpublicacionID' => 19, 'RolID' => 1, 'PersonalID' => 2, 'PublicacionID' => 18],
            ['PersonalpublicacionID' => 20, 'RolID' => 2, 'PersonalID' => 11, 'PublicacionID' => 18],
            ['PersonalpublicacionID' => 21, 'RolID' => 1, 'PersonalID' => 8, 'PublicacionID' => 19],
            ['PersonalpublicacionID' => 22, 'RolID' => 1, 'PersonalID' => 82, 'PublicacionID' => 20],
            ['PersonalpublicacionID' => 23, 'RolID' => 2, 'PersonalID' => 28, 'PublicacionID' => 20],
            ['PersonalpublicacionID' => 24, 'RolID' => 7, 'PersonalID' => 66, 'PublicacionID' => 20],
            ['PersonalpublicacionID' => 25, 'RolID' => 6, 'PersonalID' => 87, 'PublicacionID' => 20],
        ];

        DB::table('Personalpublicacion')->insertOrIgnore($personalPublicacion);
    }
}