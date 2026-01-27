<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\CargaAcademicaController;
use App\Http\Controllers\FormacionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistema SIA (Acreditación UPDS)
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. PORTADA Y REDIRECCIÓN INICIAL
// =========================================================================
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('welcome');


// =========================================================================
// 2. RUTAS DE AUTENTICACIÓN (Invitados)
// =========================================================================
Route::middleware('guest')->group(function () {
    
    Route::controller(AuthController::class)->group(function() {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');

        // RUTAS OPCIONALES DE MICROSOFT AZURE (SSO)
        Route::get('/auth/azure', 'redirectToAzure')->name('login.azure');
        Route::get('/auth/azure/callback', 'handleAzureCallback');
    });
});


// =========================================================================
// 3. RUTAS PROTEGIDAS (Usuarios Autenticados)
// =========================================================================
Route::middleware(['auth'])->group(function () {

    // --- SESIÓN Y SALIDA ---
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- DASHBOARD PRINCIPAL ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- PERFIL DEL USUARIO (Edición Propia) ---
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/perfil/edit', 'edit')->name('profile.edit');
        Route::put('/perfil/update', 'update')->name('profile.update');
    });

    // --- GESTIÓN DE PERSONAL (Solo Personal Autorizado) ---
    Route::controller(PersonalController::class)
        ->middleware('can:gestionar_personal') 
        ->group(function () {
            // Listado y Creación
            Route::get('/personal', 'index')->name('personal.index');
            Route::get('/personal/crear', 'create')->name('personal.create'); 
            Route::post('/personal', 'store')->name('personal.store');
            
            // Acciones de Estado y Cuentas (Nombres ajustados para las vistas)
            Route::post('/personal/{id}/toggle', 'toggleStatus')->name('personal.toggle');
            Route::post('/personal/{id}/crear-usuario', 'createUser')->name('personal.create_user');
            Route::post('/personal/{id}/revocar-usuario', 'revokeUser')->name('personal.revoke');
    });

    // --- VISTAS PÚBLICAS DE PERSONAL (Solo Lectura / Kardex) ---
    // Estas rutas están fuera del middleware 'gestionar_personal' para que el 
    // propio docente pueda ver su información.
    Route::get('/personal/{id}', [PersonalController::class, 'show'])->name('personal.show');
    Route::get('/personal/{id}/imprimir', [PersonalController::class, 'printInformacion'])->name('personal.print');


    // --- ACADÉMICO: CARGA HORARIA ---
    Route::controller(CargaAcademicaController::class)
        ->middleware('can:asignar_carga')
        ->group(function () {
            Route::get('/carga/asignar', 'create')->name('carga.create');
            Route::post('/carga', 'store')->name('carga.store');
        });


    // --- FORMACIÓN DOCENTE (Registro de Títulos) ---
    Route::post('/formacion', [FormacionController::class, 'store'])->name('formacion.store');


    // =========================================================================
    // 4. ANALÍTICA Y REPORTES (Power BI & Documentación Institucional)
    // =========================================================================
    Route::middleware('can:ver_dashboard')->group(function () {
        
        // Dashboards con Power BI Embebido
        Route::view('/analitica/acreditacion', 'reporte-bi')->name('analitica.acreditacion');
        Route::view('/analitica/corporativo', 'powerbi')->name('analitica.powerbi_show');

        // Visores de PDF (Reportes Estáticos)
        Route::get('/analitica/presentacion-final', function () {
            return view('reporte', [
                'archivo' => 'reporte_presentacion.pdf', 
                'titulo' => 'Presentación de Acreditación'
            ]);
        })->name('reporte.pdf');

        Route::get('/analitica/inversion-profesional', function () {
            return view('reporte', [
                'archivo' => 'Infografía de datos Oportunidades de Inversión Profesional Corporativo Azul (1).pdf', 
                'titulo' => 'Inversión Profesional'
            ]);
        })->name('reporte.inversion');
    });

    // Herramienta de Diagnóstico (Opcional)
    Route::get('/test-config', function() {
        return response()->json([
            'auth_user' => Auth::user()->Email,
            'cargo' => Auth::user()->personal->cargo->NombreCargo ?? 'Sin Cargo'
        ]);
    });

});