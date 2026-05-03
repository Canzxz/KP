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

            ->darkMode(true, true)

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
                \Filament\View\PanelsRenderHook::HEAD_END,
                fn (): string => \Illuminate\Support\Facades\Blade::render('
                    <link rel="preconnect" href="https://fonts.googleapis.com">
                    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
                    @vite("resources/css/app.css")
                ')
            )

            ->renderHook(
                PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
                fn (): string => Blade::render('
                    <style>
                        /* Background gambar di seluruh layar */
                        html, body {
                            background-image: linear-gradient(rgba(10,15,30,0.75), rgba(10,15,30,0.75)), url("/images/login-bg.png") !important;
                            background-size: cover !important;
                            background-position: center !important;
                            background-attachment: fixed !important;
                        }

                        /* Elemen luar HARUS transparan agar background terlihat */
                        .fi-simple-layout,
                        .fi-simple-main-ctn {
                            background: transparent !important;
                            background-image: none !important;
                            background-color: transparent !important;
                        }

                        /* Hanya kotak form yang solid */
                        .fi-simple-main,
                        section.fi-simple-main,
                        .fi-simple-main > div,
                        .fi-simple-main > section,
                        .fi-simple-main > form,
                        .fi-simple-main .rounded-xl,
                        .fi-simple-main [class*="dark:bg-gray"] {
                            background-color: #0d1526 !important;
                            background-image: none !important;
                        }
                        .fi-simple-main {
                            border: 1px solid rgba(59,130,246,0.2) !important;
                            border-radius: 1.25rem !important;
                            box-shadow: 0 40px 80px -20px rgba(0,0,0,0.9), 0 0 50px -10px rgba(59,130,246,0.1) !important;
                            overflow: hidden !important;
                        }
                        .fi-fo-field-wrp label {
                            font-size: 0.78rem !important;
                            font-weight: 600 !important;
                            text-transform: uppercase !important;
                            letter-spacing: 0.08em !important;
                        }
                        /* Tombol Sign In - multi-selector agar pasti terkena */
                        .fi-simple-main button[type="submit"],
                        .fi-simple-main .fi-btn,
                        .fi-simple-main [wire\:click*="authenticate"],
                        .fi-simple-main form button {
                            width: 100% !important;
                            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
                            color: white !important;
                            border: none !important;
                            border-radius: 0.625rem !important;
                            padding: 0.75rem 1.5rem !important;
                            font-size: 0.95rem !important;
                            font-weight: 700 !important;
                            letter-spacing: 0.04em !important;
                            cursor: pointer !important;
                            box-shadow: 0 4px 20px -4px rgba(37, 99, 235, 0.6) !important;
                            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
                        }
                        .fi-simple-main button[type="submit"]:hover,
                        .fi-simple-main .fi-btn:hover,
                        .fi-simple-main form button:hover {
                            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
                            transform: translateY(-2px) !important;
                            box-shadow: 0 12px 28px -6px rgba(37, 99, 235, 0.7), 0 0 20px -5px rgba(96, 165, 250, 0.4) !important;
                        }
                        .fi-simple-main button[type="submit"]:active,
                        .fi-simple-main form button:active {
                            transform: translateY(0) scale(0.99) !important;
                            box-shadow: 0 4px 10px -3px rgba(37, 99, 235, 0.4) !important;
                        }
                    </style>
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            const main = document.querySelector(".fi-simple-main");
                            if (!main) return;
                            main.querySelectorAll("*").forEach(function(el) {
                                el.style.setProperty("background-color", "#0d1526", "important");
                                el.style.setProperty("background-image", "none", "important");
                            });
                        });
                    </script>
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
                \App\Filament\Pages\Dashboard::class,
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
