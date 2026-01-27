<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\DB;   // <--- NECESARIO PARA LEER SQL
use Illuminate\Support\Facades\URL;
use App\Models\User;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Azure\AzureExtendSocialite;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 1. FORZAR HTTPS EN PRODUCCIÓN (Seguridad)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // 2. SOCIALITE / AZURE (Login con Microsoft)
        Event::listen(SocialiteWasCalled::class, [AzureExtendSocialite::class, 'handle']);

        // 3. SUPER ADMIN (Rector / Vicerrector)
        // Esta "Puerta Maestra" se ejecuta antes que cualquier otra.
        // Si tienes 'acceso_total', no pregunta nada más. Pase VIP.
        Gate::before(function (User $user, $ability) {
            if ($user->canDo('acceso_total')) {
                return true; 
            }
        });

        // 4. GATES DINÁMICOS (La Magia de la Base de Datos)
        // En lugar de escribir Gate::define 20 veces, hacemos un bucle.
        try {
            // Verificamos conexión para no romper comandos de consola si no hay BD
            // Usamos una consulta ligera solo a la tabla de catálogo
            $permisos = DB::table('Permisos')->pluck('NombrePermiso'); 

            foreach ($permisos as $permiso) {
                Gate::define($permiso, function (User $user) use ($permiso) {
                    return $user->canDo($permiso);
                });
            }

        } catch (\Exception $e) {
            // Si la tabla no existe aún (migraciones) o no hay conexión, ignoramos.
        }
    }
}