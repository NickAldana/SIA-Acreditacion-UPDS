<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ==========================================
        // NIVEL 0: CATÁLOGOS E INDEPENDIENTES
        // ==========================================

        Schema::create('Cargo', function (Blueprint $table) {
            $table->id('CargoID');
            $table->string('Nombrecargo', 255);
            $table->integer('nivel_jerarquico')->nullable();
        });

        Schema::create('Permisos', function (Blueprint $table) {
            $table->id('PermisosID');
            $table->string('Nombrepermiso', 255);
            $table->longText('Descripcion')->nullable();
        });

        Schema::create('Tipocontrato', function (Blueprint $table) {
            $table->id('TipocontratoID');
            $table->string('Nombrecontrato', 255);
            $table->longText('Descripcion')->nullable();
            $table->integer('IndicadoresID')->nullable();
        });

        Schema::create('Gradoacademico', function (Blueprint $table) {
            $table->id('GradoacademicoID');
            $table->string('Nombregrado', 255);
        });

        Schema::create('Centroformacion', function (Blueprint $table) {
            $table->id('CentroformacionID');
            $table->string('Nombrecentro', 255);
            $table->longText('Direccion')->nullable();
            $table->string('Pais', 100)->nullable();
        });

        Schema::create('Facultad', function (Blueprint $table) {
            $table->id('FacultadID');
            $table->string('CodigoFacultad', 50)->nullable();
            $table->string('Nombrefacultad', 255);
        });

        Schema::create('Materia', function (Blueprint $table) {
            $table->id('MateriaID');
            $table->string('Sigla', 20)->nullable();
            $table->string('Nombremateria', 255);
        });

        Schema::create('EntidadFinanciadora', function (Blueprint $table) {
            $table->id('EntidadFinanciadoraID');
            $table->string('NombreEntidad', 255);
            $table->string('TipoEntidad', 100)->nullable();
            $table->string('Nit', 50)->nullable();
            $table->string('ContactoNombre', 255)->nullable();
            $table->boolean('Activo')->default(true);
        });

        Schema::create('Rol', function (Blueprint $table) {
            $table->id('RolID');
            $table->string('Nombrerol', 255);
            $table->longText('Descripcion')->nullable();
        });

        Schema::create('Tipopublicacion', function (Blueprint $table) {
            $table->id('TipopublicacionID');
            $table->string('Nombretipo', 255);
            $table->longText('Descripcion')->nullable();
            $table->string('Pais', 100)->nullable();
        });

        Schema::create('Mediopublicacion', function (Blueprint $table) {
            $table->id('MediopublicacionID');
            $table->string('Nombremedio', 255);
            $table->longText('Url')->nullable();
            $table->string('Pais', 100)->nullable();
            $table->longText('Datoscontacto')->nullable();
            $table->string('Correo', 255)->nullable();
        });

        // ==========================================
        // NIVEL 1: DEPENDENCIAS SIMPLES
        // ==========================================

        Schema::create('Cargopermiso', function (Blueprint $table) {
            $table->id('CargopermisoID');
            $table->unsignedBigInteger('CargoID')->nullable();
            $table->unsignedBigInteger('PermisosID')->nullable();
            
            $table->foreign('CargoID')->references('CargoID')->on('Cargo');
            $table->foreign('PermisosID')->references('PermisosID')->on('Permisos');
        });

        Schema::create('Indicadores', function (Blueprint $table) {
            $table->id('IndicadoresID');
            $table->string('Nombreindicador', 255);
            $table->decimal('Valormaximo', 10, 2)->nullable();
            $table->decimal('Valorminimo', 10, 2)->nullable();
            $table->integer('Idcarrera')->nullable();
            $table->integer('Idtipocontrato')->nullable();
        });

        Schema::create('Carrera', function (Blueprint $table) {
            $table->id('CarreraID');
            $table->string('CodigoCarrera', 50)->nullable();
            $table->string('Nombrecarrera', 255);
            $table->unsignedBigInteger('FacultadID')->nullable();
            $table->unsignedBigInteger('IndicadoresID')->nullable();

            $table->foreign('FacultadID')->references('FacultadID')->on('Facultad');
            $table->foreign('IndicadoresID')->references('IndicadoresID')->on('Indicadores');
        });

        Schema::create('Lineainvestigacion', function (Blueprint $table) {
            $table->id('LineainvestigacionID');
            $table->string('Nombrelineainvestigacion', 255);
            $table->longText('Descripcion')->nullable();
            $table->unsignedBigInteger('FacultadID')->nullable();
            $table->boolean('EsTransversal')->default(false);

            $table->foreign('FacultadID')->references('FacultadID')->on('Facultad');
        });

        Schema::create('Fondoinversion', function (Blueprint $table) {
            $table->id('FondoinversionID');
            $table->unsignedBigInteger('EntidadFinanciadoraID');
            $table->string('NombreFondo', 255);
            $table->string('CodigoConvenio', 100)->nullable();
            $table->decimal('MontoTotalFondo', 18, 2)->nullable();
            $table->date('FechaInicio')->nullable();
            $table->date('FechaFin')->nullable();
            $table->longText('RutaConvenioPDF')->nullable();

            $table->foreign('EntidadFinanciadoraID')->references('EntidadFinanciadoraID')->on('EntidadFinanciadora');
        });

        // ==========================================
        // NIVEL 2: DEPENDENCIAS COMPLEJAS
        // ==========================================

        Schema::create('Materiacarrera', function (Blueprint $table) {
            $table->id('MateriacarreraID');
            $table->unsignedBigInteger('MateriaID');
            $table->unsignedBigInteger('CarreraID');

            $table->foreign('MateriaID')->references('MateriaID')->on('Materia');
            $table->foreign('CarreraID')->references('CarreraID')->on('Carrera');
        });

        Schema::create('Proyectoinvestigacion', function (Blueprint $table) {
            $table->id('ProyectoinvestigacionID');
            $table->string('CodigoProyecto', 50)->nullable();
            $table->longText('Nombreproyecto');
            $table->date('Fechainicio')->nullable();
            $table->date('Fechafinalizacion')->nullable();
            $table->string('Estado', 50)->nullable();
            $table->unsignedBigInteger('CarreraID')->nullable();
            $table->unsignedBigInteger('LineainvestigacionID')->nullable();

            $table->foreign('CarreraID')->references('CarreraID')->on('Carrera');
            $table->foreign('LineainvestigacionID')->references('LineainvestigacionID')->on('Lineainvestigacion');
        });

        Schema::create('PresupuestoProyecto', function (Blueprint $table) {
            $table->id('PresupuestoID');
            $table->unsignedBigInteger('ProyectoinvestigacionID');
            $table->unsignedBigInteger('FondoinversionID');
            $table->decimal('MontoAsignado', 18, 2);
            $table->date('FechaAsignacion')->nullable();
            $table->longText('Observacion')->nullable();
            $table->longText('RutaRespaldoAsignacion')->nullable();
            $table->string('Modalidad', 50)->default('Institucional');
            $table->boolean('ValidacionAcreditacion')->default(true);

            $table->foreign('ProyectoinvestigacionID')->references('ProyectoinvestigacionID')->on('Proyectoinvestigacion');
            $table->foreign('FondoinversionID')->references('FondoinversionID')->on('Fondoinversion');
        });

        Schema::create('Publicacion', function (Blueprint $table) {
            $table->id('PublicacionID');
            $table->longText('Nombrepublicacion');
            $table->date('Fechapublicacion')->nullable();
            $table->unsignedBigInteger('MediopublicacionID')->nullable();
            $table->unsignedBigInteger('ProyectoinvestigacionID')->nullable();
            $table->unsignedBigInteger('TipopublicacionID')->nullable();
            $table->longText('RutaArchivo')->nullable();
            $table->longText('UrlPublicacion')->nullable();
            $table->unsignedBigInteger('LineainvestigacionID')->nullable();
            $table->unsignedBigInteger('CarreraID')->nullable();

            $table->foreign('MediopublicacionID')->references('MediopublicacionID')->on('Mediopublicacion');
            $table->foreign('ProyectoinvestigacionID')->references('ProyectoinvestigacionID')->on('Proyectoinvestigacion');
            $table->foreign('TipopublicacionID')->references('TipopublicacionID')->on('Tipopublicacion');
            $table->foreign('LineainvestigacionID')->references('LineainvestigacionID')->on('Lineainvestigacion');
            $table->foreign('CarreraID')->references('CarreraID')->on('Carrera');
        });

        // ==========================================
        // NIVEL 3: EL NÚCLEO (PERSONAL)
        // ==========================================

        Schema::create('Personal', function (Blueprint $table) {
            $table->id('PersonalID');
            $table->string('CodigoItem', 50)->nullable();
            $table->string('Nombrecompleto', 255);
            $table->string('Apellidopaterno', 100)->nullable();
            $table->string('Apellidomaterno', 100)->nullable();
            $table->string('Ci', 20);
            $table->string('Correoelectronico', 255)->nullable();
            $table->date('Fechanacimiento')->nullable();
            $table->string('Genero', 20)->nullable();
            $table->string('Telelefono', 20)->nullable(); 
            $table->longText('Fotoperfil')->nullable();
            $table->integer('Añosexperiencia')->nullable();
            $table->boolean('Activo')->default(true);
            
            // FKs
            $table->unsignedBigInteger('CargoID')->nullable();
            $table->unsignedBigInteger('GradoacademicoID')->nullable();
            $table->unsignedBigInteger('TipocontratoID')->nullable();
            $table->unsignedBigInteger('UsuarioID'); 

            // Relaciones
            $table->foreign('CargoID')->references('CargoID')->on('Cargo');
            $table->foreign('GradoacademicoID')->references('GradoacademicoID')->on('Gradoacademico');
            $table->foreign('TipocontratoID')->references('TipocontratoID')->on('Tipocontrato');
            $table->foreign('UsuarioID')->references('UsuarioID')->on('usuario');
        });

        // ==========================================
        // NIVEL 4: DETALLES DEL PERSONAL (HIJOS)
        // ==========================================

        Schema::create('Formacion', function (Blueprint $table) {
            $table->id('FormacionID');
            $table->string('NombreProfesion', 255)->nullable();
            $table->string('Tituloobtenido', 255);
            $table->integer('Añosestudios')->nullable();
            $table->longText('RutaArchivo')->nullable();
            $table->unsignedBigInteger('CentroformacionID')->nullable();
            $table->unsignedBigInteger('PersonalID')->nullable();
            $table->unsignedBigInteger('GradoacademicoID')->nullable();

            $table->foreign('CentroformacionID')->references('CentroformacionID')->on('Centroformacion');
            $table->foreign('PersonalID')->references('PersonalID')->on('Personal');
            $table->foreign('GradoacademicoID')->references('GradoacademicoID')->on('Gradoacademico');
        });

        Schema::create('Personalmateria', function (Blueprint $table) {
            $table->id('PersonalmateriaID');
            
            // 1. COORDENADAS
            $table->integer('Gestion')->nullable(); 
            $table->integer('Periodo')->nullable(); 
            $table->string('Grupo', 20)->default('A'); 
            $table->string('Modalidad', 50)->default('Presencial'); 

            // 2. EVIDENCIA CUALITATIVA (El Informe del Docente)
            // El docente sube su informe de fin de curso: "Cumplí con el 90% del avance..."
            $table->string('RutaAutoevaluacion', 255)->nullable(); 

            // 3. EVIDENCIA CUANTITATIVA (El Resultado de los Alumnos)
            // Aquí guardas el PROMEDIO que le dieron los alumnos (Ej: 85.50)
            // No votan aquí, solo guardamos el resultado final para el reporte.
            $table->decimal('NotaEvaluacion', 5, 2)->nullable(); 

            // RELACIONES
            $table->unsignedBigInteger('PersonalID')->nullable();
            $table->unsignedBigInteger('MateriaID')->nullable();

            $table->foreign('PersonalID')->references('PersonalID')->on('Personal');
            $table->foreign('MateriaID')->references('MateriaID')->on('Materia');
        });

        Schema::create('Personalproyecto', function (Blueprint $table) {
            $table->id('PersonalproyectoID');
            $table->string('Rol', 100)->nullable();
            $table->boolean('EsResponsable')->default(false);
            $table->date('FechaInicio')->nullable();
            $table->date('FechaFin')->nullable();
            $table->unsignedBigInteger('PersonalID')->nullable();
            $table->unsignedBigInteger('ProyectoinvestigacionID')->nullable();

            $table->foreign('PersonalID')->references('PersonalID')->on('Personal');
            $table->foreign('ProyectoinvestigacionID')->references('ProyectoinvestigacionID')->on('Proyectoinvestigacion');
        });

        Schema::create('Personalpublicacion', function (Blueprint $table) {
            $table->id('PersonalpublicacionID');
            $table->unsignedBigInteger('RolID')->nullable();
            $table->unsignedBigInteger('PersonalID')->nullable();
            $table->unsignedBigInteger('PublicacionID')->nullable();

            $table->foreign('RolID')->references('RolID')->on('Rol');
            $table->foreign('PersonalID')->references('PersonalID')->on('Personal');
            $table->foreign('PublicacionID')->references('PublicacionID')->on('Publicacion');
        });
    }

    public function down(): void
    {
        // Orden Inverso de Eliminación
        Schema::dropIfExists('Personalpublicacion');
        Schema::dropIfExists('Personalproyecto');
        Schema::dropIfExists('Personalmateria');
        Schema::dropIfExists('Formacion');
        Schema::dropIfExists('Personal');
        
        Schema::dropIfExists('Publicacion');
        Schema::dropIfExists('PresupuestoProyecto');
        Schema::dropIfExists('Proyectoinvestigacion');
        Schema::dropIfExists('Materiacarrera');
        
        Schema::dropIfExists('Fondoinversion');
        Schema::dropIfExists('Lineainvestigacion');
        Schema::dropIfExists('Carrera');
        Schema::dropIfExists('Indicadores');
        Schema::dropIfExists('Cargopermiso');
        
        Schema::dropIfExists('Mediopublicacion');
        Schema::dropIfExists('Tipopublicacion');
        Schema::dropIfExists('Rol');
        Schema::dropIfExists('EntidadFinanciadora');
        Schema::dropIfExists('Materia');
        Schema::dropIfExists('Facultad');
        Schema::dropIfExists('Centroformacion');
        Schema::dropIfExists('Gradoacademico');
        Schema::dropIfExists('Tipocontrato');
        Schema::dropIfExists('Permisos');
        Schema::dropIfExists('Cargo');
    }
};