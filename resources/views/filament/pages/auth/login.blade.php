@extends('filament-panels::layout.simple')

@section('body')
    <style>
        /* Background Halaman Login */
        html, body {
            background-image:
                linear-gradient(135deg, rgba(10, 15, 30, 0.80) 0%, rgba(10, 15, 30, 0.70) 100%),
                url('{{ asset('images/login-bg.png') }}') !important;
            background-size: cover !important;
            background-position: center !important;
            background-attachment: fixed !important;
        }

        /* Override Filament Card - Solid (Tidak Tembus Pandang) */
        .fi-simple-main {
            background: #0d1526 !important;
            border: 1px solid rgba(59, 130, 246, 0.2) !important;
            border-radius: 1.25rem !important;
            box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.9), 0 0 60px -10px rgba(59, 130, 246, 0.1) !important;
            overflow: hidden !important;
        }

        /* Hapus background transparan pada wrapper luar */
        .fi-simple-layout {
            background: transparent !important;
        }

        .fi-simple-main-ctn {
            background: transparent !important;
        }

        /* Label Input */
        .fi-fo-field-wrp label {
            color: #94a3b8 !important;
            font-size: 0.78rem !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.08em !important;
        }

        /* Input Fields */
        .fi-input {
            background: rgba(255, 255, 255, 0.04) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            border-radius: 0.5rem !important;
        }

        .fi-input:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
        }

        /* Tombol Sign In */
        .fi-btn-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
            border-radius: 0.625rem !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 15px -3px rgba(37, 99, 235, 0.5) !important;
            transition: all 0.2s ease !important;
        }

        .fi-btn-primary:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 8px 20px -3px rgba(37, 99, 235, 0.6) !important;
        }

        /* Forgot Password */
        .fi-link { color: #3b82f6 !important; font-size: 0.82rem !important; }
        .fi-link:hover { color: #60a5fa !important; }
    </style>

    {{ $slot }}
@endsection
