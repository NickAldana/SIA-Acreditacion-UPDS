<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route; // Importante para la modularización
use App\Models\Usuario;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Registro de servicios.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap de servicios de la aplicación.
     */
    public function boot(): void
    {
        // 1. SEGURIDAD Y ENTORNO
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // 2. MODULARIZACIÓN DE RUTAS (Limpieza de web.php)
        // Esto permite que tus archivos en routes/*.php se carguen automáticamente
        $this->mapCustomRoutes();

        // 3. CONTROL DE ACCESO (RBAC)
        $this->configurePermissions();

        // 4. DATOS GLOBALES PARA VISTAS (Sidebar/Navbar)
        $this->composeGlobalViews();
    }

    /**
     * Carga archivos de rutas adicionales para mantener web.php limpio.
     */
protected function mapCustomRoutes(): void
{
    if (!app()->runningInConsole()) {
        Route::middleware(['web', 'auth'])->group(function () {
            foreach (glob(base_path('routes/modules/*.php')) as $file) {
                require $file;
            }
        });
    }
}
    /**
     * Configuración dinámica de Gates y Super Admin.
     */
    protected function configurePermissions(): void
    {
        if (!Schema::hasTable('Permisos')) return;

        // Super Admin (God Mode)
        Gate::before(function ($user, $ability) {
            if ($user instanceof Usuario && $user->canDo('acceso_total')) {
                return true; 
            }
        });

        // Registro de Gates dinámicos desde BD con Caché
        try {
            $nombresPermisos = Cache::remember('db_lista_permisos', 3600, function () {
                return DB::table('Permisos')->pluck('Nombrepermiso')->toArray();
            });

            foreach ($nombresPermisos as $nombre) {
                Gate::define($nombre, function (Usuario $user) use ($nombre) {
                    return $user->canDo($nombre);
                });
            }
        } catch (\Exception $e) {
            report($e); // Reporta el error pero no rompe la app
        }
    }

    /**
     * Comparte datos del usuario con todas las vistas.
     */
    protected function composeGlobalViews(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $cacheKey = 'sidebar_user_' . Auth::id();
                
                $currentUser = Cache::remember($cacheKey, 300, function () {
                    return Usuario::with([
                        'personal:PersonalID,Nombrecompleto,Fotoperfil,CargoID,UsuarioID',
                        'personal.cargo:CargoID,Nombrecargo'
                    ])->find(Auth::id());
                });
                
                $view->with('currentUser', $currentUser);
            }
        });
    }

}