<x-filament-widgets::widget>
    <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-[#1152d4] to-[#0a368c] p-10 flex flex-col md:flex-row items-center justify-between shadow-2xl shadow-blue-900/20">
        <div class="relative z-10">
            <h1 class="text-white text-5xl font-black leading-tight tracking-tight mb-4">
                Selamat Datang, {{ auth()->user()->name }}
            </h1>
            <p class="text-blue-100/80 text-lg font-medium leading-relaxed mb-8">
                Bisnis material Anda berjalan <span class="text-white font-bold underline decoration-white/30">Lancar & Terkendali</span> hari ini. Pantau stok dan transaksi terbaru Anda di sini.
            </p>
        </div>

        <!-- Decorative elements — minimalist -->
        <div class="absolute top-[-10%] right-[-5%] w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
    </div>
</x-filament-widgets::widget>
