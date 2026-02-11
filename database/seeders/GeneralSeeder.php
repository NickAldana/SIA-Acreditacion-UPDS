<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GeneralSeeder extends Seeder
{
    public function run(): void
    {
        // 0. LIMPIEZA TOTAL (Evita errores de integridad referencial SEG-02)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $tablas = [
            'Cargopermiso', 'Permisos', 'Cargo', 'usuario', 'Personal', 'Facultad', 
            'Gradoacademico', 'Tipocontrato', 'Indicadores', 'Lineainvestigacion', 
            'Centroformacion', 'Rol', 'Mediopublicacion', 'Tipopublicacion', 'EntidadFinanciadora'
        ];
        foreach ($tablas as $tabla) { DB::table($tabla)->truncate(); }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ==========================================
        // 1. FACULTADES (Nivel 0)
        // ==========================================
        DB::table('Facultad')->insert([
            ['FacultadID' => 1, 'CodigoFacultad' => 'FAC-ING', 'Nombrefacultad' => 'Facultad de Ingeniería'],
            ['FacultadID' => 2, 'CodigoFacultad' => 'FAC-EMP', 'Nombrefacultad' => 'Facultad de Ciencias Empresariales'],
            ['FacultadID' => 3, 'CodigoFacultad' => 'FAC-JUR', 'Nombrefacultad' => 'Facultad de Ciencias Jurídicas'],
            ['FacultadID' => 4, 'CodigoFacultad' => 'FAC-SOC', 'Nombrefacultad' => 'Facultad de Ciencias Sociales'],
            ['FacultadID' => 5, 'CodigoFacultad' => 'FAC-SAL', 'Nombrefacultad' => 'Facultad de Ciencias de la Salud'],
        ]);

        // ==========================================
        // 2. CATÁLOGOS RRHH (Nivel 0)
        // ==========================================
        DB::table('Gradoacademico')->insert([
            ['GradoacademicoID' => 1, 'Nombregrado' => 'Licenciatura'],
            ['GradoacademicoID' => 2, 'Nombregrado' => 'Diplomado'],
            ['GradoacademicoID' => 3, 'Nombregrado' => 'Especialidad'],
            ['GradoacademicoID' => 4, 'Nombregrado' => 'Maestría'],
            ['GradoacademicoID' => 5, 'Nombregrado' => 'Doctorado'],
        ]);

        DB::table('Centroformacion')->insert([
            ['CentroformacionID' => 1, 'Nombrecentro' => 'Universidad Privada Domingo Savio', 'Direccion' => 'Santa Cruz', 'Pais' => 'Bolivia'],
        ]);

        // ESTRUCTURA DE CARGOS AJUSTADA (SEG-04: Jerarquía 0-100)
        DB::table('Cargo')->insert([
            ['CargoID' => 1, 'Nombrecargo' => 'Rector', 'nivel_jerarquico' => 100],
            ['CargoID' => 2, 'Nombrecargo' => 'Vicerrector', 'nivel_jerarquico' => 95],
            ['CargoID' => 3, 'Nombrecargo' => 'Director de Acreditación', 'nivel_jerarquico' => 90],
            ['CargoID' => 4, 'Nombrecargo' => 'Director de Investigación', 'nivel_jerarquico' => 90],
            ['CargoID' => 5, 'Nombrecargo' => 'Decano', 'nivel_jerarquico' => 80],
            ['CargoID' => 6, 'Nombrecargo' => 'Jefe de Carrera', 'nivel_jerarquico' => 50],
            ['CargoID' => 7, 'Nombrecargo' => 'Secretaria / Asistente', 'nivel_jerarquico' => 40],
            ['CargoID' => 8, 'Nombrecargo' => 'Docente', 'nivel_jerarquico' => 10],
            ['CargoID' => 9, 'Nombrecargo' => 'Estudiante Investigador', 'nivel_jerarquico' => 5],
        ]);

        DB::table('Tipocontrato')->insert([
            ['TipocontratoID' => 1, 'Nombrecontrato' => 'Docente Externo', 'Descripcion' => 'Migrado legacy', 'IndicadoresID' => null],
            ['TipocontratoID' => 2, 'Nombrecontrato' => 'Indefinido Tiempo Completo', 'Descripcion' => 'Migrado legacy', 'IndicadoresID' => null],
            ['TipocontratoID' => 3, 'Nombrecontrato' => 'Indefinido Medio Tiempo', 'Descripcion' => 'Migrado legacy', 'IndicadoresID' => null],
            ['TipocontratoID' => 4, 'Nombrecontrato' => 'Tiempo Completo Permanente', 'Descripcion' => 'Migrado legacy', 'IndicadoresID' => null],
            ['TipocontratoID' => 5, 'Nombrecontrato' => 'Medio Tiempo Permanente', 'Descripcion' => 'Migrado legacy', 'IndicadoresID' => null],
            ['TipocontratoID' => 6, 'Nombrecontrato' => 'Tiempo Completo - Plazo Fijo', 'Descripcion' => 'Migrado legacy', 'IndicadoresID' => null],
            ['TipocontratoID' => 7, 'Nombrecontrato' => 'Medio Tiempo - Plazo Fijo', 'Descripcion' => 'Migrado legacy', 'IndicadoresID' => null],
            ['TipocontratoID' => 8, 'Nombrecontrato' => 'Tiempo Completo con Sábado', 'Descripcion' => 'Migrado legacy', 'IndicadoresID' => null],
        ]);

        // ==========================================
        // 3. INDICADORES (Nivel 0)
        // ==========================================
        DB::table('Indicadores')->insert([
            ['IndicadoresID' => 1, 'Nombreindicador' => 'Porcentaje de Docentes con Posgrado', 'Valormaximo' => 0.40, 'Valorminimo' => 0.20, 'Idcarrera' => null, 'Idtipocontrato' => null],
            ['IndicadoresID' => 2, 'Nombreindicador' => 'Porcentaje de Docentes con Doctorado', 'Valormaximo' => 0.05, 'Valorminimo' => 0.01, 'Idcarrera' => null, 'Idtipocontrato' => null],
            ['IndicadoresID' => 3, 'Nombreindicador' => 'Promedio de Alumnos por Materia', 'Valormaximo' => 30.00, 'Valorminimo' => 15.00, 'Idcarrera' => null, 'Idtipocontrato' => null],
            ['IndicadoresID' => 4, 'Nombreindicador' => 'Publicaciones por Docente (Anual)', 'Valormaximo' => 2.00, 'Valorminimo' => 1.00, 'Idcarrera' => null, 'Idtipocontrato' => null],
            ['IndicadoresID' => 5, 'Nombreindicador' => 'Ratio de Docentes de Planta', 'Valormaximo' => 0.45, 'Valorminimo' => 0.25, 'Idcarrera' => null, 'Idtipocontrato' => null],
            ['IndicadoresID' => 6, 'Nombreindicador' => 'Cumplimiento Profesión Afín (General)', 'Valormaximo' => 0.80, 'Valorminimo' => 0.60, 'Idcarrera' => null, 'Idtipocontrato' => null],
        ]);

        // ==========================================
        // 4. LÍNEAS DE INVESTIGACIÓN (23 REGISTROS COMPLETOS)
        // ==========================================
        DB::table('Lineainvestigacion')->insert([
            ['LineainvestigacionID' => 1, 'Nombrelineainvestigacion' => 'INTELIGENCIA ARTIFICIAL Y CIENCIA DE DATOS', 'Descripcion' => 'Desarrollo de modelos predictivos, machine learning y análisis de big data.', 'FacultadID' => 1, 'EsTransversal' => 0],
            ['LineainvestigacionID' => 2, 'Nombrelineainvestigacion' => 'CIBERSEGURIDAD Y REDES', 'Descripcion' => 'Protección de infraestructuras críticas, criptografía y seguridad informática.', 'FacultadID' => 1, 'EsTransversal' => 0],
            ['LineainvestigacionID' => 3, 'Nombrelineainvestigacion' => 'TRANSFORMACIÓN DIGITAL Y SOFTWARE', 'Descripcion' => 'Ingeniería de software, desarrollo web/móvil y automatización de procesos.', 'FacultadID' => 1, 'EsTransversal' => 0],
            ['LineainvestigacionID' => 4, 'Nombrelineainvestigacion' => 'SISTEMAS INTELIGENTES Y ROBÓTICA', 'Descripcion' => 'Diseño de hardware y software para sistemas autónomos y control industrial.', 'FacultadID' => 1, 'EsTransversal' => 0],
            ['LineainvestigacionID' => 5, 'Nombrelineainvestigacion' => 'EMPRENDIMIENTO E INNOVACIÓN EMPRESARIAL', 'Descripcion' => 'Creación de startups, modelos de negocio disruptivos y gestión de la innovación.', 'FacultadID' => 2, 'EsTransversal' => 0],
            ['LineainvestigacionID' => 6, 'Nombrelineainvestigacion' => 'MARKETING ESTRATÉGICO Y DIGITAL', 'Descripcion' => 'Comportamiento del consumidor, e-commerce y estrategias de mercado.', 'FacultadID' => 2, 'EsTransversal' => 0],
            ['LineainvestigacionID' => 7, 'Nombrelineainvestigacion' => 'FINANZAS Y MERCADOS DE CAPITALES', 'Descripcion' => 'Gestión financiera, valoración de riesgos y economía corporativa.', 'FacultadID' => 2, 'EsTransversal' => 0],
            ['LineainvestigacionID' => 8, 'Nombrelineainvestigacion' => 'GESTIÓN DEL TALENTO HUMANO', 'Descripcion' => 'Liderazgo, cultura organizacional y nuevas tendencias en RRHH.', 'FacultadID' => 2, 'EsTransversal' => 0],
            ['LineainvestigacionID' => 9, 'Nombrelineainvestigacion' => 'DERECHOS HUMANOS Y CONSTITUCIONALIDAD', 'Descripcion' => 'Protección de derechos fundamentales y análisis constitucional.', 'FacultadID' => 3, 'EsTransversal' => 0],
            ['LineainvestigacionID' => 10, 'Nombrelineainvestigacion' => 'DERECHO PENAL Y CRIMINOLOGÍA', 'Descripcion' => 'Estudio del delito, sistemas penitenciarios y política criminal.', 'FacultadID' => 3, 'EsTransversal' => 0],
            ['LineainvestigacionID' => 11, 'Nombrelineainvestigacion' => 'DERECHO CORPORATIVO Y EMPRESARIAL', 'Descripcion' => 'Marco legal para empresas, contratos internacionales y arbitraje.', 'FacultadID' => 3, 'EsTransversal' => 0],
            ['LineainvestigacionID' => 12, 'Nombrelineainvestigacion' => 'DERECHO PROCESAL Y LITIGACIÓN', 'Descripcion' => 'Nuevas tendencias en la resolución de conflictos y oralidad procesal.', 'FacultadID' => 3, 'EsTransversal' => 0],
            ['LineainvestigacionID' => 13, 'Nombrelineainvestigacion' => 'PSICOLOGÍA CLÍNICA Y DE LA SALUD', 'Descripcion' => 'Intervención psicológica, salud mental y bienestar emocional.', 'FacultadID' => 4, 'EsTransversal' => 0],
            ['LineainvestigacionID' => 14, 'Nombrelineainvestigacion' => 'INNOVACIÓN EDUCATIVA Y PEDAGOGÍA', 'Descripcion' => 'Tecnologías en la educación, neuroeducación y nuevos métodos de enseñanza.', 'FacultadID' => 4, 'EsTransversal' => 0],
            ['LineainvestigacionID' => 15, 'Nombrelineainvestigacion' => 'COMUNICACIÓN ESTRATÉGICA Y MEDIOS', 'Descripcion' => 'Periodismo digital, comunicación corporativa y análisis de medios.', 'FacultadID' => 4, 'EsTransversal' => 0],
            ['LineainvestigacionID' => 16, 'Nombrelineainvestigacion' => 'SOCIOLOGÍA Y DESARROLLO COMUNITARIO', 'Descripcion' => 'Análisis de problemáticas sociales, inclusión y desarrollo urbano.', 'FacultadID' => 4, 'EsTransversal' => 0],
            ['LineainvestigacionID' => 17, 'Nombrelineainvestigacion' => 'SALUD PÚBLICA Y EPIDEMIOLOGÍA', 'Descripcion' => 'Prevención de enfermedades, gestión sanitaria y estudios epidemiológicos.', 'FacultadID' => 5, 'EsTransversal' => 0],
            ['LineainvestigacionID' => 18, 'Nombrelineainvestigacion' => 'ATENCIÓN CLÍNICA Y CUIDADOS INTEGRALES', 'Descripcion' => 'Nuevos protocolos médicos, enfermería avanzada y atención al paciente.', 'FacultadID' => 5, 'EsTransversal' => 0],
            ['LineainvestigacionID' => 19, 'Nombrelineainvestigacion' => 'NUTRICIÓN Y DIETÉTICA APLICADA', 'Descripcion' => 'Seguridad alimentaria, nutrición clínica y deportiva.', 'FacultadID' => 5, 'EsTransversal' => 0],
            ['LineainvestigacionID' => 20, 'Nombrelineainvestigacion' => 'FARMACOLOGÍA Y BIOQUÍMICA', 'Descripcion' => 'Estudio de nuevos fármacos y análisis bioquímicos clínicos.', 'FacultadID' => 5, 'EsTransversal' => 0],
            ['LineainvestigacionID' => 21, 'Nombrelineainvestigacion' => 'RESPONSABILIDAD SOCIAL Y SOSTENIBILIDAD', 'Descripcion' => 'Proyectos enfocados en los ODS, medio ambiente e impacto social.', 'FacultadID' => null, 'EsTransversal' => 1],
            ['LineainvestigacionID' => 22, 'Nombrelineainvestigacion' => 'ÉTICA Y DEONTOLOGÍA PROFESIONAL', 'Descripcion' => 'Valores éticos en el ejercicio profesional y académico.', 'FacultadID' => null, 'EsTransversal' => 1],
            ['LineainvestigacionID' => 23, 'Nombrelineainvestigacion' => 'METODOLOGÍA DE LA INVESTIGACIÓN CIENTÍFICA', 'Descripcion' => 'Desarrollo de competencias investigativas y producción académica.', 'FacultadID' => null, 'EsTransversal' => 1],
        ]);

        // ==========================================
        // 5. CATÁLOGOS DE PUBLICACIÓN
        // ==========================================
        DB::table('Rol')->insert([
            ['RolID' => 1, 'Nombrerol' => 'AUTOR PRINCIPAL', 'Descripcion' => 'Responsable principal de la investigación'],
            ['RolID' => 2, 'Nombrerol' => 'CO-AUTOR', 'Descripcion' => 'Colaborador con aporte intelectual significativo'],
            ['RolID' => 3, 'Nombrerol' => 'TUTOR / ASESOR', 'Descripcion' => 'Guía académico del trabajo de investigación'],
            ['RolID' => 4, 'Nombrerol' => 'DIRECTOR DE TESIS', 'Descripcion' => 'Responsable de la dirección metodológica'],
            ['RolID' => 5, 'Nombrerol' => 'ESTUDIANTE INVESTIGADOR', 'Descripcion' => 'Alumno participando en semilleros o proyectos'],
            ['RolID' => 6, 'Nombrerol' => 'REVISOR TÉCNICO', 'Descripcion' => 'Encargado de la validación técnica'],
            ['RolID' => 7, 'Nombrerol' => 'COLABORADOR', 'Descripcion' => 'Apoyo en tareas operativas o recolección de datos'],
        ]);

        DB::table('Mediopublicacion')->insert([
            ['MediopublicacionID' => 1, 'Nombremedio' => 'REVISTA CIENTÍFICA UPDS', 'Url' => 'https://www.upds.edu.bo', 'Pais' => 'Bolivia'],
            ['MediopublicacionID' => 2, 'Nombremedio' => 'EDITORIAL ACADÉMICA ESPAÑOLA', 'Url' => 'https://www.eae-publishing.com', 'Pais' => 'España'],
            ['MediopublicacionID' => 3, 'Nombremedio' => 'REVISTA CIENCIA Y TECNOLOGÍA', 'Url' => null, 'Pais' => 'Internacional'],
            ['MediopublicacionID' => 4, 'Nombremedio' => 'IEEE XPLORE', 'Url' => 'https://ieeexplore.ieee.org', 'Pais' => 'EE.UU.'],
            ['MediopublicacionID' => 5, 'Nombremedio' => 'SCOPUS INDEXED JOURNAL', 'Url' => 'https://www.scopus.com', 'Pais' => 'Internacional'],
            ['MediopublicacionID' => 6, 'Nombremedio' => 'SCIELO BOLIVIA', 'Url' => 'http://www.scielo.org.bo', 'Pais' => 'Bolivia'],
            ['MediopublicacionID' => 7, 'Nombremedio' => 'LATINDEX', 'Url' => 'https://www.latindex.org', 'Pais' => 'México'],
            ['MediopublicacionID' => 8, 'Nombremedio' => 'EDITORIAL HOGUERA', 'Url' => null, 'Pais' => 'Bolivia'],
            ['MediopublicacionID' => 9, 'Nombremedio' => 'MEDIO DIGITAL INDEPENDIENTE', 'Url' => null, 'Pais' => 'Global'],
            ['MediopublicacionID' => 10, 'Nombremedio' => 'SIN EDITORIAL / INÉDITO', 'Url' => null, 'Pais' => 'Local'],
            ['MediopublicacionID' => 11, 'Nombremedio' => 'REVISTA INDEXADA', 'Url' => null, 'Pais' => 'Internacional'],
            ['MediopublicacionID' => 12, 'Nombremedio' => 'REPOSITORIO ORCID', 'Url' => 'https://orcid.org', 'Pais' => 'Global'],
            ['MediopublicacionID' => 13, 'Nombremedio' => 'GOOGLE SCHOLAR PROFILE', 'Url' => 'https://scholar.google.com', 'Pais' => 'Global'],
            ['MediopublicacionID' => 14, 'Nombremedio' => 'RESEARCHGATE', 'Url' => 'https://www.researchgate.net', 'Pais' => 'Alemania'],
        ]);

        DB::table('Tipopublicacion')->insert([
            ['TipopublicacionID' => 1, 'Nombretipo' => 'ARTÍCULO CIENTÍFICO', 'Descripcion' => 'Publicación en revista especializada'],
            ['TipopublicacionID' => 2, 'Nombretipo' => 'LIBRO', 'Descripcion' => 'Obra completa propia o compartida'],
            ['TipopublicacionID' => 3, 'Nombretipo' => 'CAPÍTULO DE LIBRO', 'Descripcion' => 'Contribución dentro de obra colectiva'],
            ['TipopublicacionID' => 4, 'Nombretipo' => 'ENSAYO', 'Descripcion' => 'Texto argumentativo específico'],
            ['TipopublicacionID' => 5, 'Nombretipo' => 'MONOGRAFÍA', 'Descripcion' => 'Estudio detallado sobre un aspecto'],
            ['TipopublicacionID' => 6, 'Nombretipo' => 'TEXTO GUÍA O MANUAL', 'Descripcion' => 'Material didáctico de apoyo'],
            ['TipopublicacionID' => 7, 'Nombretipo' => 'MEMORIA DE CONGRESO', 'Descripcion' => 'Trabajo presentado en conferencias'],
            ['TipopublicacionID' => 8, 'Nombretipo' => 'PROTOTIPO INDUSTRIAL', 'Descripcion' => 'Innovación tecnológica'],
            ['TipopublicacionID' => 9, 'Nombretipo' => 'SOFTWARE REGISTRADO', 'Descripcion' => 'Desarrollo con derechos de autor'],
            ['TipopublicacionID' => 10, 'Nombretipo' => 'ARTÍCULO DE REVISIÓN', 'Descripcion' => 'Análisis del estado del arte'],
            ['TipopublicacionID' => 11, 'Nombretipo' => 'TESIS DOCTORAL', 'Descripcion' => 'Investigación grado máximo'],
            ['TipopublicacionID' => 12, 'Nombretipo' => 'PATENTE', 'Descripcion' => 'Derecho exclusivo de invención'],
        ]);

        DB::table('EntidadFinanciadora')->insert([
            ['EntidadFinanciadoraID' => 1, 'NombreEntidad' => 'INTERNA UPDS', 'TipoEntidad' => 'Universidad', 'Activo' => 1],
        ]);

        // =================================================================================
        // 6. SEGURIDAD: DICCIONARIO V5.0 (PERMISOS GRANULARES)
        // =================================================================================
        DB::table('Permisos')->insert([
            ['PermisosID' => 1, 'Nombrepermiso' => 'acceso_total', 'Descripcion' => 'GOD MODE: Acceso total al sistema.'],
            ['PermisosID' => 2, 'Nombrepermiso' => 'gestion_seguridad', 'Descripcion' => 'Gestión de usuarios y contraseñas.'],
            ['PermisosID' => 3, 'Nombrepermiso' => 'auditar_sistema', 'Descripcion' => 'Ver bitácora de actividad y logs.'],
            ['PermisosID' => 4, 'Nombrepermiso' => 'ver_directorio_personal', 'Descripcion' => 'Ver lista de contacto institucional.'],
            ['PermisosID' => 5, 'Nombrepermiso' => 'registrar_alta_personal', 'Descripcion' => 'Crear nuevos registros de personal.'],
            ['PermisosID' => 6, 'Nombrepermiso' => 'gestion_formacion', 'Descripcion' => 'Subir títulos y gestionar formación.'],
            ['PermisosID' => 7, 'Nombrepermiso' => 'ver_datos_sensibles', 'Descripcion' => 'Ver sueldos y contratos privados.'],
            ['PermisosID' => 8, 'Nombrepermiso' => 'subir_produccion_propia', 'Descripcion' => 'Subir investigaciones propias.'],
            ['PermisosID' => 9, 'Nombrepermiso' => 'validar_produccion', 'Descripcion' => 'Aprobar investigaciones de terceros.'],
            ['PermisosID' => 10, 'Nombrepermiso' => 'gestion_proyectos', 'Descripcion' => 'Crear y gestionar proyectos investigación.'],
            ['PermisosID' => 11, 'Nombrepermiso' => 'gestion_academica', 'Descripcion' => 'Asignar carga horaria y grupos.'],
            ['PermisosID' => 12, 'Nombrepermiso' => 'ver_dashboard_bi', 'Descripcion' => 'Visualizar KPIs estratégicos.'],
            ['PermisosID' => 13, 'Nombrepermiso' => 'ver_perfil_propio', 'Descripcion' => 'Acceso a su propia información.'],
        ]);

      // ==========================================
        // 7. MATRIZ DE ASIGNACIÓN CORREGIDA Y COMPLETA
        // ==========================================
        $asignaciones = [
            // RECTOR (ID 1): God Mode + Dashboard + Auditoría
            ['CargoID' => 1, 'PermisosID' => 1], 
            ['CargoID' => 1, 'PermisosID' => 12], 
            ['CargoID' => 1, 'PermisosID' => 3], 
            ['CargoID' => 1, 'PermisosID' => 13],

            // VICERRECTOR (ID 2): Estratégico + Dashboard + Ver Datos Sensibles (Sueldos)
            ['CargoID' => 2, 'PermisosID' => 12], 
            ['CargoID' => 2, 'PermisosID' => 7], 
            ['CargoID' => 2, 'PermisosID' => 4],
            ['CargoID' => 2, 'PermisosID' => 13],

            // DIR ACREDITACIÓN (ID 3): El "Auditor" (Ve todo para validar calidad)
             ['CargoID' => 3, 'PermisosID' => 1],
            ['CargoID' => 3, 'PermisosID' => 12], // Dashboard BI
            ['CargoID' => 3, 'PermisosID' => 3],  // Auditar logs
            ['CargoID' => 3, 'PermisosID' => 4],  // Ver directorio
            ['CargoID' => 3, 'PermisosID' => 9],  // Validar producción ajena
            ['CargoID' => 3, 'PermisosID' => 11], // Gestión académica
            ['CargoID' => 3, 'PermisosID' => 13], // Perfil propio

            // DECANO (ID 4): Supervisión de Facultad
            ['CargoID' => 4, 'PermisosID' => 12], 
            ['CargoID' => 4, 'PermisosID' => 4], 
            ['CargoID' => 4, 'PermisosID' => 11], 
            ['CargoID' => 4, 'PermisosID' => 13],

            // JEFE DE CARRERA (ID 5): Operativo Académico (Asigna materias)
            ['CargoID' => 5, 'PermisosID' => 11], // Gestión académica [cite: 62]
            ['CargoID' => 5, 'PermisosID' => 4],  // Ver su personal
            ['CargoID' => 5, 'PermisosID' => 6],  // Gestionar formación
            ['CargoID' => 5, 'PermisosID' => 13],

            // DOCENTE (ID 6): El ID correcto según tu tabla Cargo
            ['CargoID' => 6, 'PermisosID' => 8],  // Subir producción propia [cite: 67]
            ['CargoID' => 6, 'PermisosID' => 13], // Ver perfil propio [cite: 60]

            // SECRETARIA (ID 7): Operativo RRHH
            ['CargoID' => 7, 'PermisosID' => 5],  // Registrar altas [cite: 59]
            ['CargoID' => 7, 'PermisosID' => 6],  // Gestionar títulos [cite: 59]
            ['CargoID' => 7, 'PermisosID' => 4],  // Ver directorio
            ['CargoID' => 7, 'PermisosID' => 13],

            // ESTUDIANTE INVESTIGADOR (ID 9): Mínimo acceso
            ['CargoID' => 9, 'PermisosID' => 8],  // Subir investigaciones [cite: 76]
            ['CargoID' => 9, 'PermisosID' => 13], // Ver su perfil
        ];
        DB::table('Cargopermiso')->insert($asignaciones);
 

      
    }
}