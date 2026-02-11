<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicoSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. CARRERAS (Completo)
        // ==========================================
        $carreras = [
            // Facultad de Ingeniería (ID 1)
            ['CarreraID' => 1, 'CodigoCarrera' => 'Ing', 'Nombrecarrera' => 'Ingeniería de Sistemas', 'FacultadID' => 1],
            ['CarreraID' => 2, 'CodigoCarrera' => 'Ing', 'Nombrecarrera' => 'Ingeniería de Redes y Telecomunicaciones', 'FacultadID' => 1],
            ['CarreraID' => 3, 'CodigoCarrera' => 'Ing', 'Nombrecarrera' => 'Ingeniería Industrial', 'FacultadID' => 1],
            ['CarreraID' => 4, 'CodigoCarrera' => 'Ing', 'Nombrecarrera' => 'Ingeniería Civil', 'FacultadID' => 1],
            ['CarreraID' => 5, 'CodigoCarrera' => 'Ing', 'Nombrecarrera' => 'Ingeniería en Gestión Petrolera', 'FacultadID' => 1],
            ['CarreraID' => 6, 'CodigoCarrera' => 'Ing', 'Nombrecarrera' => 'Ingeniería en Gestión Ambiental', 'FacultadID' => 1],
            
            // Facultad de Ciencias Empresariales (ID 2)
            ['CarreraID' => 7, 'CodigoCarrera' => 'Adm', 'Nombrecarrera' => 'Administración de Empresas', 'FacultadID' => 2],
            ['CarreraID' => 8, 'CodigoCarrera' => 'Con', 'Nombrecarrera' => 'Contaduría Pública', 'FacultadID' => 2],
            ['CarreraID' => 9, 'CodigoCarrera' => 'Ing', 'Nombrecarrera' => 'Ingeniería Comercial', 'FacultadID' => 2],
            ['CarreraID' => 10, 'CodigoCarrera' => 'Mar', 'Nombrecarrera' => 'Marketing y Publicidad', 'FacultadID' => 2],
            
            // Facultad de Ciencias Jurídicas (ID 3)
            ['CarreraID' => 11, 'CodigoCarrera' => 'Der', 'Nombrecarrera' => 'Derecho', 'FacultadID' => 3],
            
            // Facultad de Ciencias Sociales (ID 4)
            ['CarreraID' => 12, 'CodigoCarrera' => 'Psi', 'Nombrecarrera' => 'Psicología', 'FacultadID' => 4],
            ['CarreraID' => 13, 'CodigoCarrera' => 'Psi', 'Nombrecarrera' => 'Psicopedagogía', 'FacultadID' => 4],
            ['CarreraID' => 14, 'CodigoCarrera' => 'Cie', 'Nombrecarrera' => 'Ciencias de la Comunicación Social', 'FacultadID' => 4],
            ['CarreraID' => 15, 'CodigoCarrera' => 'Rel', 'Nombrecarrera' => 'Relaciones Internacionales', 'FacultadID' => 4],
            ['CarreraID' => 16, 'CodigoCarrera' => 'Ges', 'Nombrecarrera' => 'Gestión del Turismo', 'FacultadID' => 4],
            
            // Facultad de Ciencias de la Salud (ID 5)
            ['CarreraID' => 17, 'CodigoCarrera' => 'Med', 'Nombrecarrera' => 'Medicina', 'FacultadID' => 5],
            ['CarreraID' => 18, 'CodigoCarrera' => 'Bio', 'Nombrecarrera' => 'Bioquímica y Farmacia', 'FacultadID' => 5],
            ['CarreraID' => 19, 'CodigoCarrera' => 'Fis', 'Nombrecarrera' => 'Fisioterapia y Kinesiología', 'FacultadID' => 5],
            ['CarreraID' => 20, 'CodigoCarrera' => 'Nut', 'Nombrecarrera' => 'Nutrición y Dietética', 'FacultadID' => 5],
        ];

        DB::table('Carrera')->insertOrIgnore($carreras);

        // ==========================================
        // 2. MATERIAS (Extracción Masiva y Migración)
        // ==========================================
        // Formato Raw: [ID, Sigla, Nombre, CarreraID_Original]
        $materiasRaw = [
            // Ing. Sistemas (1)
            [1, 'MAT-0125', 'Estructuras Discretas', 1],
            [22, 'SIS-0310', 'Administración de Base de Datos I', 1],
            [23, 'SIS-0320', 'Sistemas de Información I', 1],
            [24, 'SIS-0141', 'Diseño Web II', 1],
            [25, 'SIS-0250', 'Inteligencia Artificial I', 1],
            [26, 'SIS-0330', 'Desarrollo de Sistemas II', 1],
            [27, 'SIS-0321', 'Sistemas de Información II', 1],
            [28, 'SIS-0124', 'Programación IV', 1],
            [49, 'ADM-0420', 'Emprendedurismo', 1],

            // Ing. Redes (2)
            [50, 'MAT-0125', 'Estructuras Discretas', 2],
            [51, 'MAT-0100', 'Fundamentos de Matemáticas', 2],
            [52, 'INV-0100', 'Técnicas de Investigación', 2],
            [53, 'ELC-0100', 'Hardware y Software', 2],
            [54, 'LIN-0200', 'Inglés I', 2],
            [55, 'SIS-0120', 'Programación Básica', 2],
            [77, 'RED-0110', 'Instalación y Certificación de Redes', 2],
            [78, 'ELC-0220', 'Electrónica I', 2],
            [79, 'SIS-0310', 'Administración de Base de Datos I', 2],
            [80, 'TEL-0220', 'Medios de Transmisión', 2],
            [81, 'TEL-0310', 'Comunicaciones Digitales I', 2],
            [82, 'SIS-0230', 'Taller de Sistemas Operativos II', 2],
            [83, 'RED-0120', 'Redes II', 2],

            // Ing. Industrial (3)
            [105, 'MAT-0200', 'Estadística Descriptiva', 3],
            [106, 'MAT-0120', 'Cálculo I', 3],
            [107, 'CON-0100', 'Contabilidad Empresarial I', 3],
            [108, 'FIS-0200', 'Física II', 3],
            [109, 'QMC-0200', 'Química Orgánica', 3],
            [110, 'MAT-0110', 'Álgebra Lineal', 3],
            [111, 'IND-0100', 'Dibujo Industrial Computarizado', 3],
            [132, 'MAT-0310', 'Investigación Operativa II', 3],
            [133, 'IND-0201', 'Gestión de la Calidad II', 3],
            [134, 'IND-0500', 'Procesos Industriales I', 3],
            [135, 'ADM-0200', 'Comportamiento Organizacional', 3],
            [136, 'IND-0600', 'Gestión del Mantenimiento', 3],
            [137, 'ADM-0420', 'Emprendedurismo', 3],
            [138, 'ELC-0120', 'Circuitos Eléctricos y Digitales', 3],

            // Administración (7)
            [215, 'ECO-0301', 'Macroeconomía', 7],
            [216, 'FIN-0201', 'Finanzas Empresariales I', 7],
            [217, 'ADM-0402', 'Gestión de Recursos Humanos', 7],
            [218, 'MKT-0301', 'Principios de Marketing', 7],
            [219, 'MAT-0300', 'Investigación Operativa I', 7],
            [220, 'ADM-0501', 'Comportamiento Organizacional', 7],
            [221, 'ADM-0502', 'Organización y Sistemas', 7],

            // Contaduría (8)
            [242, 'ADM-0101', 'Administración I', 8],
            [243, 'ECO-0100', 'Introducción a la Economía', 8],
            [244, 'CON-0101', 'Contabilidad Empresarial I', 8],
            [245, 'MAT-0120', 'Cálculo I', 8],
            [246, 'DER-0501', 'Derecho Comercial I', 8],
            [247, 'CON-0201', 'Normas Contables', 8],
            [248, 'ADM-0201', 'Administración II', 8],
            [249, 'ECO-0201', 'Microeconomía I', 8],
            [271, 'CON-0602', 'Contabilidad Agropecuaria', 8],
            [272, 'FIN-0301', 'Finanzas Empresariales II', 8],
            [273, 'FIN-0302', 'Análisis e Interpretación de EEFF', 8],
            [274, 'EMP-0101', 'Emprendedurismo', 8],
            [275, 'AUD-0201', 'Auditoría II', 8],
            [276, 'ADM-0703', 'Presupuestos y Planificación', 8],
            [277, 'AUD-0202', 'Auditoría Ambiental', 8],

            // Ing. Comercial (9)
            [299, 'EST-0210', 'Estadística Inferencial', 9],
            [300, 'MKT-0201', 'Investigación de Mercado II', 9],
            [301, 'ADM-0301', 'Administración para la Toma de Decisiones', 9],
            [302, 'ECO-0202', 'Microeconomía II', 9],
            [303, 'CON-0301', 'Contabilidad de Costos I', 9],
            [304, 'FIN-0101', 'Matemática Financiera', 9],
            [305, 'TRI-0101', 'Tributación Aplicada I', 9],
            [306, 'ADM-0402', 'Gestión de Recursos Humanos', 9],
            [327, 'CAL-0101', 'Gestión de la Calidad I', 9],
            [328, 'MKT-0701', 'Gestión de Marketing de Servicios e Industrial', 9],
            [329, 'MKT-0702', 'Servicio al Cliente', 9],
            [330, 'FIN-0401', 'Trading', 9],

            // Marketing (10)
            [331, 'LIN-0101', 'Lingüística', 10],
            [332, 'MAT-0100', 'Fundamentos de Matemáticas', 10],
            [333, 'INV-0100', 'Técnicas de Investigación', 10],
            [354, 'MKT-0401', 'Comportamiento del Consumidor', 10],
            [355, 'MKT-0501', 'Producto', 10],
            [356, 'MKT-0502', 'Plaza', 10],
            [357, 'VEN-0101', 'Ventas', 10],
            [358, 'COM-0101', 'Comercio Exterior', 10],
            [359, 'PUB-0201', 'Producción y Difusión de Materiales Corporativos I', 10],
            [360, 'MKT-0503', 'Precio', 10],

            // Derecho (11)
            [160, 'DER-0206', 'Derechos Humanos', 11],
            [161, 'DER-0301', 'Ley del Órgano Judicial', 11],
            [162, 'DER-0302', 'Derecho Civil II', 11],
            [163, 'DER-0303', 'Derecho Penal II', 11],
            [164, 'DER-0304', 'Derecho Constitucional II', 11],
            [165, 'DER-0305', 'Filosofía del Derecho', 11],
            [166, 'DER-0306', 'Derecho Económico y Financiero', 11],
            [187, 'DER-0703', 'Procedimiento Penal', 11],
            [188, 'DER-0704', 'Procedimiento Constitucional', 11],
            [189, 'DER-0705', 'Derecho Internacional Privado', 11],
            [190, 'DER-0706', 'Gramática y Argumentación Jurídica', 11],
            [191, 'DER-0801', 'Métodos Alternos de Solución de Conflictos', 11],
            [192, 'DER-0802', 'Clínica Legal I', 11],
            [193, 'DER-0803', 'Clínica Legal II', 11],

            // Psicología (12)
            [463, 'DIA-0101', 'Psicodiagnóstico', 12],
            [464, 'PRO-0301', 'Técnicas Proyectivas III', 12],
            [465, 'ORI-0101', 'Orientación Vocacional', 12],
            [466, 'ADM-0420', 'Emprendedurismo', 12],

            // Psicopedagogía (13)
            [467, 'RED-0101', 'Redacción y Estilo', 13],
            [468, 'ETI-0101', 'Deontología y Prosocialidad', 13],
            [469, 'ART-0101', 'Taller de Expresión Artística', 13],
            [470, 'EDU-0101', 'Sistema Educativo', 13],
            [492, 'EDU-0301', 'Dificultades de Aprendizaje', 13],
            [493, 'ESP-0101', 'Educación Especial I', 13],
            [494, 'PSI-0403', 'Psicología Cognitiva', 13],
            [495, 'EDU-0302', 'Educación para la Diversidad e Interculturalidad', 13],
            [496, 'INV-0301', 'Investigación Aplicada I', 13],
            [497, 'TES-0601', 'Taller de Test Psicopedagógicos', 13],
            [498, 'DIA-0201', 'Diagnóstico Psicopedagógico', 13],
            [499, 'EVA-0401', 'Evaluación Educativa', 13],

            // Comunicación Social (14)
            [382, 'COM-0201', 'Redacción y Estilo', 14],
            [383, 'COM-0202', 'Teorías y Modelos de la Comunicación', 14],
            [384, 'PSI-0101', 'Psicología de la Comunicación', 14],
            [385, 'EST-0200', 'Estadística Descriptiva', 14],
            [386, 'SOC-0101', 'Análisis Crítico de la Realidad Nacional e Internacional', 14],
            [387, 'COM-0203', 'Semiótica y Lenguaje de la Imagen', 14],
            [388, 'COM-0301', 'Redacción Periodística y Géneros Informativos', 14],
            [407, 'MED-0201', 'Planificación Estratégica de Medios', 14],
            [408, 'DIR-0101', 'DIRCOM', 14],
            [409, 'PRO-0301', 'Proyectos de Desarrollo Social en Comunicación', 14],

            // Relaciones Internacionales (15)
            [520, 'DER-0202', 'Derecho Constitucional I', 15],
            [521, 'RIN-0201', 'Teorías de las Relaciones Internacionales I', 15],
            [522, 'EST-0200', 'Estadística Descriptiva', 15],
            [523, 'HIS-0201', 'Historia Sociopolítica Boliviana', 15],
            [524, 'ORA-0301', 'Técnicas de Oratoria', 15],
            [525, 'POL-0301', 'Ciencia Política II', 15],
            [526, 'DER-0302', 'Derecho Constitucional II', 15],
            [547, 'INT-0601', 'Integración', 15],
            [548, 'PRO-0701', 'Etiqueta, Protocolo y Ceremonial', 15],
            [549, 'ORG-0701', 'Organizaciones Internacionales', 15],
            [550, 'PAZ-0701', 'Teoría de Paz', 15],
            [551, 'DIP-0701', 'Diplomacia', 15],
            [552, 'ECO-0701', 'Economía Política', 15],
            [553, 'EVE-0801', 'Gestión de Eventos', 15],

            // Medicina (17)
            [575, 'SAL-0301', 'Salud Pública II', 17],
            [576, 'CLI-0301', 'Simulación Clínica II', 17],
            [577, 'MED-0304', 'Microbiología', 17],
            [578, 'ETI-0301', 'Ética y Deontología', 17],
            [579, 'INF-0301', 'Inteligencia Artificial y Ciencia de Datos en Medicina', 17],
            [580, 'MED-0401', 'Anatomía Patológica', 17],
            [581, 'MED-0402', 'Fisiopatología General', 17],
            [603, 'MED-0704', 'Nutrición Clínica', 17],
            [604, 'MED-0705', 'Endocrinología', 17],
            [605, 'ADM-0701', 'Administración en Salud', 17],
            [606, 'EME-0701', 'Emergencias y Desastres', 17],
            [607, 'MED-0801', 'Gastroenterología', 17],
            [608, 'MED-0802', 'Oftalmología', 17],
            [609, 'MED-0803', 'Otorrinolaringología', 17],
            [610, 'CLI-0801', 'Clínica Pediátrica I', 17],

            // Bioquímica (18)
            [768, 'FAR-0401', 'Farmacología General', 18],
            [769, 'BIO-0403', 'Enzimología', 18],
            [770, 'MIC-0401', 'Microbiología y Técnicas de Laboratorio', 18],
            [771, 'QUI-0302', 'Química Analítica Cuantitativa', 18],
            [772, 'TEC-0401', 'Tecnología Farmacéutica', 18],
            [773, 'SAL-0401', 'Salud Pública y Epidemiología', 18],
            [774, 'LIN-0404', 'Inglés Técnico IV', 18],
            [796, 'HEM-0802', 'Hematología II', 18],
            [797, 'BIO-0804', 'Bioclínica Aplicada', 18],
            [798, 'IMM-0802', 'Inmunología Clínica y Virología', 18],
            [799, 'GES-0801', 'Gestión de Calidad en Laboratorio', 18],

            // Fisioterapia (19)
            [632, 'KIN-0101', 'Kinefilaxia en el Deporte', 19],
            [633, 'DIS-0101', 'Discapacidad y Sociedad', 19],
            [634, 'SAL-0101', 'Salud Pública I', 19],
            [635, 'EST-0101', 'Bioestadística e Investigación', 19],
            [636, 'LIN-0101', 'Inglés Técnico I', 19],
            [637, 'MED-0201', 'Anatomía Humana II', 19],
            [638, 'MED-0202', 'Fisiología I', 19],
            [639, 'MED-0203', 'Bioquímica', 19],
            [660, 'TER-0401', 'Terapia Ocupacional', 19],
            [661, 'KIN-0501', 'Kinesiología y Biomecánica', 19],
            [662, 'MED-0502', 'Neuropatología y Fisioterapia I', 19],
            [663, 'CLI-0502', 'Clínica Propedéutica en Fisioterapia', 19],
            [664, 'KIN-0507', 'Fisioterapia Cardiorrespiratoria', 19],
            [665, 'KIN-0508', 'Fisioterapia y Kinesiología en Traumatología', 19],
            [666, 'DIS-0502', 'Psicomotricidad', 19],
            [686, 'MED-0806', 'Neurología y Neurocirugía', 19],
            [687, 'CLI-0803', 'Clínica Pediátrica', 19],

            // Nutrición (20)
            [688, 'MED-0101', 'Anatomía Humana I', 20],
            [689, 'NUT-0101', 'Técnica Dietética I', 20],
            [690, 'INV-0101', 'Metodología de la Investigación', 20],
            [691, 'BIO-0101', 'Biología y Genética aplicada a la Nutrición', 20],
            [692, 'NUT-0102', 'Introducción a la Nutrición', 20],
            [714, 'SEG-0401', 'Seguridad Alimentaria', 20],
            [715, 'PSI-0501', 'Psicología de la Nutrición I', 20],
            [716, 'MED-0503', 'Fisiopatología I', 20],
            [717, 'NUT-0506', 'Introducción a los Servicios de Alimentación', 20],
            [718, 'TOX-0501', 'Toxicología de Alimentos', 20],
            [719, 'NUT-0507', 'Introducción a la Nutrición Clínica y Dietoterapia', 20],
            [720, 'NUT-0508', 'Nutrición Ortomolecular', 20],
            [739, 'NUT-0809', 'Nutrición Clínica en Pediatría', 20],
            [740, 'NUT-0810', 'Dietoterapia en diferentes Patologías', 20],
            [741, 'NUT-0811', 'Dietoterapia en Pediatría', 20],
            [742, 'INT-0901', 'Internado Rotatorio', 20],
            [743, 'NUT-0902', 'Nutrición en Situaciones Clínicas', 20],
            [744, 'NUT-0903', 'Nutrición Deportiva', 20],
            [745, 'SAL-0903', 'Salud Pública', 20],
        ];

        // LOGICA DE MIGRACIÓN: SQL (1:N) -> LARAVEL (N:M)
        // Separamos Materia y Materiacarrera
        $materias = [];
        $relaciones = [];

        foreach ($materiasRaw as $m) {
            $id = $m[0];
            $sigla = $m[1];
            $nombre = $m[2];
            $carrerasIds = [$m[3]]; // En el script viejo es 1, en el nuevo puede ser array

            // 1. Preparamos Materia (Sin ID de Carrera)
            $materias[] = [
                'MateriaID' => $id,
                'Sigla' => $sigla,
                'Nombremateria' => $nombre
            ];

            // 2. Preparamos Tabla Puente (Materiacarrera)
            foreach ($carrerasIds as $carreraId) {
                $relaciones[] = [
                    'MateriaID' => $id,
                    'CarreraID' => $carreraId
                ];
            }
        }

        // Insertar en Bloques (Chunks) para Velocidad
        foreach (array_chunk($materias, 500) as $chunk) {
            DB::table('Materia')->insertOrIgnore($chunk);
        }

        foreach (array_chunk($relaciones, 1000) as $chunk) {
            DB::table('Materiacarrera')->insertOrIgnore($chunk);
        }
    }
}