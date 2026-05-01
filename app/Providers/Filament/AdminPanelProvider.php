<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\KasirWidget;
use App\Filament\Widgets\TransaksiChart;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->passwordReset()

            ->brandName('Toko Bangunan Hadi')
            ->brandLogo(asset('images/logo.png'))
            ->brandLogoHeight('3rem')
            ->favicon(asset('images/logo.png'))

            ->font('Poppins')

            ->darkMode(true, true)

            ->colors([
                'primary' => Color::Emerald,
                'gray' => [
                    50  => '#f6f6f8',
                    100 => '#e2e4e8',
                    200 => '#c8cbd2',
                    300 => '#a4a9b4',
                    400 => '#7c8291',
                    500 => '#636a79',
                    600 => '#4e5462',
                    700 => '#3b4050',
                    800 => '#1e2433',
                    900 => '#151b28',
                    950 => '#101622',
                ],
            ])

            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => Blade::render('
                    <link rel="preconnect" href="https://fonts.googleapis.com">
                    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
                    @vite("resources/css/app.css")
                ')
            )



            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\\Filament\\Resources'
            )

            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\\Filament\\Pages'
            )

            ->pages([
                Pages\Dashboard::class,
            ])

            ->discoverWidgets(
                in: app_path('Filament/Widgets'),
                for: 'App\\Filament\\Widgets'
            )

            ->widgets([])

            ->navigationGroups([
                'Menu',
            ])

            ->navigationItems([
                // Default navigation items will be used
            ])

            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])

            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
