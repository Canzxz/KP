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

            ->brandLogo(fn () => view('filament.admin.brand'))

            ->font('Poppins')

            ->darkMode(true)

            ->colors([
                'primary' => Color::Blue,
                'emerald' => Color::Emerald,
                'gray' => Color::Slate,
            ])

            ->renderHook(
                PanelsRenderHook::SIDEBAR_NAV_START,
                fn (): string => view('filament.admin.sidebar-profile'),
            )

            ->renderHook(
                \Filament\View\PanelsRenderHook::HEAD_START,
                fn (): string => \Illuminate\Support\Facades\Blade::render('
                    <script>
                        (function() {
                            try {
                                const theme = localStorage.getItem("theme") || "dark";
                                if (theme === "dark") {
                                    document.documentElement.classList.add("dark");
                                } else {
                                    document.documentElement.classList.remove("dark");
                                }
                            } catch (e) {}
                        })();
                    </script>
                ')
            )

            ->renderHook(
                \Filament\View\PanelsRenderHook::HEAD_END,
                fn (): string => \Illuminate\Support\Facades\Blade::render('
                    <link rel="preconnect" href="https://fonts.googleapis.com">
                    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
                    <style>
                        /* Consistently handle backgrounds and sidebars in PHP hook to bypass cache */
                        html:not(.dark) body, 
                        html:not(.dark) .fi-main { background-color: #e2e8f0 !important; }
                        html:not(.dark) .fi-sidebar { background-color: #f8fafc !important; }
                        
                        /* Fix Table/Card/Stats Visibility */
                        html:not(.dark) .fi-ta-ctn,
                        html:not(.dark) .fi-section,
                        html:not(.dark) .fi-wi-stats-overview-stat {
                            background-color: #ffffff !important;
                            color: #1e293b !important;
                        }
                        
                        html:not(.dark) .fi-wi-stats-overview-stat * {
                            color: #1e293b !important;
                        }

                        html:not(.dark) .fi-ta-row,
                        html:not(.dark) tr,
                        html:not(.dark) td {
                            background-color: #ffffff !important;
                            color: #1e293b !important;
                        }

                        /* Fix Page Titles Visibility */
                        html:not(.dark) .fi-header-heading {
                            color: #111827 !important; 
                            opacity: 1 !important;
                        }

                        html.dark body,
                        html.dark .fi-main { background-color: #0f172a !important; }
                        html.dark .fi-sidebar { background-color: #111c2e !important; }
                        html.dark .fi-wi-stats-overview-stat { background-color: #1e293b !important; }
                    </style>
                    @vite("resources/css/app.css")
                ')
            )

            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => str_contains(request()->url(), 'login') ? Blade::render('
                    <style>
                        /* RESET & BASE */
                        body {
                            background-image: linear-gradient(rgba(10,15,30,0.85), rgba(10,15,30,0.85)), url("/images/login-bg.png") !important;
                            background-size: cover !important;
                            background-position: center !important;
                            background-attachment: fixed !important;
                            background-color: #050a15 !important;
                        }

                        /* HIDE FILAMENT DEFAULT BACKGROUNDS */
                        .fi-simple-layout, .fi-simple-main-ctn, .fi-simple-main > div {
                            background: transparent !important;
                            background-color: transparent !important;
                        }

                        /* THE CARD - Kedalaman & Warna */
                        .fi-simple-main {
                            background-color: #0d1526 !important; /* Biru Gelap sesuai foto */
                            border: 1px solid rgba(59, 130, 246, 0.4) !important;
                            border-radius: 1.5rem !important;
                            box-shadow: 0 25px 60px -12px rgba(0, 0, 0, 0.8) !important;
                            padding: 2.5rem !important;
                            max-width: 460px !important;
                        }

                        /* TEXT & LABELS - Paksa Putih */
                        .fi-simple-header-heading, 
                        .fi-fo-field-wrp label, 
                        [class*="fi-logo"],
                        .fi-simple-main *,
                        .fi-simple-main span,
                        .fi-simple-main p {
                            color: #ffffff !important;
                        }

                        /* LOGO & BRAND */
                        [class*="fi-logo"] {
                            font-size: 1.5rem !important;
                            font-weight: 900 !important;
                            letter-spacing: -0.03em !important;
                        }

                        /* SIGN IN TITLE */
                        .fi-simple-header-heading {
                            font-size: 2rem !important;
                            margin-top: 1rem !important;
                            margin-bottom: 2rem !important;
                            font-weight: 800 !important;
                            text-align: center !important;
                        }

                        /* FORM LABELS */
                        .fi-fo-field-wrp label span {
                            color: #ffffff !important;
                            font-size: 0.85rem !important;
                            font-weight: 700 !important;
                            text-transform: uppercase !important;
                        }

                        /* INPUT FIELDS - Tanpa Efek Bersinar */
                        .fi-input-wrp {
                            background-color: rgba(0, 0, 0, 0.3) !important;
                            border: 1px solid rgba(255, 255, 255, 0.1) !important; /* Border tipis samar */
                            border-radius: 0.75rem !important;
                        }
                        .fi-input-wrp:focus-within {
                            border-color: rgba(59, 130, 246, 0.5) !important;
                            box-shadow: none !important;
                        }
                        .fi-input-wrp input {
                            color: white !important;
                            font-weight: 500 !important;
                        }

                        /* FORGOT PASSWORD */
                        .fi-link {
                            color: #94a3b8 !important; /* Warna slate yang lebih tenang */
                            font-weight: 600 !important;
                        }

                        /* SIGN IN BUTTON */
                        .fi-simple-main button[type="submit"] {
                            margin-top: 1.5rem !important;
                            background: #1e293b !important;
                            border: 1px solid rgba(255, 255, 255, 0.1) !important;
                            color: white !important;
                            border-radius: 0.75rem !important;
                            font-weight: 800 !important;
                            padding: 0.85rem !important;
                            text-transform: capitalize !important;
                            box-shadow: none !important;
                            transition: all 0.2s !important;
                        }
                        .fi-simple-main button[type="submit"]:hover {
                            background: #334155 !important;
                        }

                        /* CHECKBOX */
                        .fi-checkbox {
                            border-color: rgba(255,255,255,0.2) !important;
                            background-color: rgba(255,255,255,0.05) !important;
                        }
                    </style>
                ') : ''
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
                \App\Filament\Pages\Dashboard::class,
            ])

            ->discoverWidgets(
                in: app_path('Filament/Widgets'),
                for: 'App\\Filament\\Widgets'
            )

            ->widgets([
                \App\Filament\Widgets\DashboardStatsOverview::class,
                \App\Filament\Widgets\KasirWidget::class,
                \App\Filament\Widgets\TransaksiChart::class,
            ])

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
