<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define o caminho para onde os usuários são redirecionados após o login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define as rotas da aplicação.
     */
    public function boot(): void
    {
        $this->routes(function () {
            // Carrega rotas da API com prefixo /api
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Carrega rotas web
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
